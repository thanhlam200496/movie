<?php

namespace App\Http\Controllers\admins;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Episode;
use App\Models\LeechMovieUrl;
use App\Models\Movie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Promise\Utils;


class LeechMovieController extends Controller
{
    public function getMovies($slug, Request $request)
    {
        $leechUrl = LeechMovieUrl::where('slug', $slug)->first();
        $client = new Client();
        $page = $request->page ?? 1;
        $apiUrl = $leechUrl->url_list_movie;
        $response = $client->get($apiUrl . $page);

        // Kiểm tra nếu gọi thành công
        if ($response->getStatusCode() === 200) {
            $movies = json_decode($response->getBody(), true); // Chuyển JSON thành mảng PHP
            // dd($movies);
            // Trả về kết quả hoặc xử lý dữ liệu
            return view('admin_movie.leech_movie.list', ['movies' => $movies['items'], 'leechUrl' => $leechUrl, 'pagination' => $movies['pagination']]);
        }

        return response()->json(['message' => 'Failed to fetch data'], 500);
    }
    public function getOneMovies(Request $request)
    {
        // $leechUrl=LeechMovieUrl::where('slug',$slug)->first();
        $client = new Client();
        // $page = $request->page ?? 1;
        // $apiUrl=$leechUrl->url_list_movie;
        $response = $client->get($request->leechUrl);

        // Kiểm tra nếu gọi thành công
        if ($response->getStatusCode() === 200) {
            $movies = json_decode($response->getBody(), true); // Chuyển JSON thành mảng PHP
            // dd($movies);
            // Trả về kết quả hoặc xử lý dữ liệu
            // dd($movies);
            return view('admin_movie.leech_movie.create', ['movies' => $movies['movie']]);
        }

        return response()->json(['message' => 'Failed to fetch data'], 500);
    }



    // hàm gốc
      public function importAllMoviesWithEpisodes($slug, Request $request)
       {
           ini_set('max_execution_time', 0);
           $startTime = microtime(true);

           $leechUrl = LeechMovieUrl::where('slug', $slug)->firstOrFail();
           $client = new Client(['timeout' => 15]);

           $trangdau = $request->trangdau;
           $trangcuoi = $request->trangcuoi;

           if ($trangdau > $trangcuoi) {
               [$trangdau, $trangcuoi] = [$trangcuoi, $trangdau];
           }

          $allMovies = [];

           // 🔹 Bước 1: Lấy danh sách phim từ tất cả các trang
           for ($page = $trangdau; $page <= $trangcuoi; $page++) {
               $response = $client->get($leechUrl->url_list_movie . $page);
               if ($response->getStatusCode() !== 200) continue;
               $data = json_decode($response->getBody(), true);
               $movies = $data['items'] ?? [];
               $allMovies = array_merge($allMovies, $movies);
           }

           // 🔹 Bước 2: Chuẩn bị request song song tới API chi tiết phim
           $requests = function ($movies) use ($client, $leechUrl) {
               foreach ($movies as $movieDataNomal) {
                   yield function () use ($client, $leechUrl, $movieDataNomal) {
                       return $client->getAsync($leechUrl->url_detail . $movieDataNomal['slug'], [
                           'meta' => ['movie_basic' => $movieDataNomal]
                       ]);
                   };
               }
           };

           $concurrency = 20; // số lượng request chạy song song
           $pool = new Pool($client, $requests($allMovies), [
               'concurrency' => $concurrency,
               'fulfilled' => function (Response $response, $index) use ($allMovies) {
                   try {
                       $movieDataNomal = $allMovies[$index];
                       $detailsData = json_decode($response->getBody(), true);
                       $episodesData = $detailsData['episodes'] ?? [];
                       $movieData = $detailsData['movie'] ?? null;

                       if (!$movieData) {
                           Log::warning("Thiếu dữ liệu phim: {$movieDataNomal['slug']}");
                           return;
                       }

                       DB::beginTransaction();
                       // Lưu ảnh vào storage
                       $posterFilm = file_get_contents($movieData['thumb_url']);
                       $fileName = basename($movieData['thumb_url']);
                       Storage::put('public/images/' . $fileName, $posterFilm);
                       $movie = Movie::updateOrCreate(
                           ['slug' => $movieDataNomal['slug']],
                           [
                               'title' => $movieDataNomal['name'],
                               'slug' => $movieDataNomal['slug'],
                               'release_year' => $movieDataNomal['year'],
                               'poster_url' => $fileName,
                               'link_poster_internet' => $movieData['thumb_url'] ?? '',
                               'status' => 'Public',
                               'description' => $movieData['content'] ?? '',
                               'trailer_url' => $movieData['trailer_url'] ?? '',
                               'rating' => $movieData['tmdb']['vote_average'] ?? null,
                               'views' => $movieData['view'] ?? null,
                               'countries' => $movieData['country'][0]['name'] ?? null,
                               'duration' => $movieData['time'] ?? null,
                               'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',
                           ]
                       );

                       // Gắn category
                       foreach ($movieData['category'] as $category) {
                           $categoryNew = Category::firstOrCreate(
                               ['slug' => $category['slug']],
                               ['name' => $category['name']]
                           );
                           $movie->categories()->syncWithoutDetaching([$categoryNew->id]);
                       }

                     //   Lưu tập phim
                       $episodesToInsert = [];
                       foreach ($episodesData as $episode) {
                           foreach ($episode['server_data'] as $ep) {
                               $episodeNumber = (count($episode['server_data']) == 1) ? 'Full' : $ep['name'];
                               $episodesToInsert[] = [
                                   'movie_id' => $movie->id,
                                   'episode_number' => $episodeNumber,
                                   'title' => "{$movie->title} - {$ep['name']}",
                                   'link_video_internet' => $ep['link_m3u8'] ?? null,
                                   'created_at' => now(),
                                   'updated_at' => now(),
                               ];
                           }
                       }

                       if (!empty($episodesToInsert)) {
                           Episode::insert($episodesToInsert);
                       }

                       DB::commit();
                   } catch (\Throwable $e) {
                       DB::rollBack();
                       Log::error("Lỗi khi lưu phim: {$e->getMessage()}");
                   }
               },
               'rejected' => function ($reason, $index) {
                   Log::error('Request failed: ' . $reason->getMessage());
               },
           ]);

           $promise = $pool->promise();
           $promise->wait();

           $executionTime = round(microtime(true) - $startTime, 2);
           Log::info("Import xong {$executionTime}s cho " . count($allMovies) . " phim");

           return redirect()->back()->with('success', "Leech thành công {$executionTime}s cho " . count($allMovies) . " phim");
       }




    //     // hàm của AI, chưa tự tạo category
    // public function importAllMoviesWithEpisodes($slug, Request $request)
    // {
    //     ini_set('max_execution_time', 0);
    //     $startTime = microtime(true);

    //     $leechUrl = LeechMovieUrl::where('slug', $slug)->firstOrFail();
    //     $client = new Client(['timeout' => 15]);

    //     $trangdau = $request->trangdau;
    //     $trangcuoi = $request->trangcuoi;

    //     if ($trangdau > $trangcuoi) {
    //         [$trangdau, $trangcuoi] = [$trangcuoi, $trangdau];
    //     }

    //     $allMovies = [];

    //     // 🔹 Bước 1: Lấy danh sách phim từ tất cả các trang
    //     for ($page = $trangdau; $page <= $trangcuoi; $page++) {
    //         $response = $client->get($leechUrl->url_list_movie . $page);
    //         if ($response->getStatusCode() !== 200) continue;

    //         $data = json_decode($response->getBody(), true);
    //         $movies = $data['items'] ?? [];
    //         $allMovies = array_merge($allMovies, $movies);
    //     }

    //     // 🔹 Bước 2: Tạo danh mục ban đầu (nếu có sẵn)
    //     $allCategories = collect($allMovies)
    //         ->flatMap(fn($movie) => $movie['category'] ?? [])
    //         ->unique('slug')
    //         ->map(fn($cat) => Category::firstOrCreate(
    //             ['slug' => $cat['slug']],
    //             ['name' => $cat['name']]
    //         ))
    //         ->keyBy('slug');

    //     // 🔹 Bước 3: Chuẩn bị request song song tới API chi tiết phim
    //     $requests = function ($movies) use ($client, $leechUrl) {
    //         foreach ($movies as $movieDataNomal) {
    //             yield function () use ($client, $leechUrl, $movieDataNomal) {
    //                 return $client->getAsync($leechUrl->url_detail . $movieDataNomal['slug'], [
    //                     'meta' => ['movie_basic' => $movieDataNomal]
    //                 ]);
    //             };
    //         }
    //     };

    //     $concurrency = 20;
    //     $pool = new Pool($client, $requests($allMovies), [
    //         'concurrency' => $concurrency,
    //         'fulfilled' => function (Response $response, $index) use ($allMovies, &$allCategories) {
    //             try {
    //                 $movieDataNomal = $allMovies[$index];
    //                 $detailsData = json_decode($response->getBody(), true);
    //                 $episodesData = $detailsData['episodes'] ?? [];
    //                 $movieData = $detailsData['movie'] ?? null;

    //                 if (!$movieData) {
    //                     Log::warning("Thiếu dữ liệu phim: {$movieDataNomal['slug']}");
    //                     return;
    //                 }

    //                 DB::beginTransaction();

    //                 // 🔹 Lưu ảnh vào storage
    //                 $posterFilm = file_get_contents($movieData['thumb_url']);
    //                 $fileName = basename($movieData['thumb_url']);
    //                 Storage::put('public/images/' . $fileName, $posterFilm);

    //                 // 🔹 Tạo hoặc cập nhật phim
    //                 $movie = Movie::updateOrCreate(
    //                     ['slug' => $movieDataNomal['slug']],
    //                     [
    //                         'title' => $movieDataNomal['name'],
    //                         'slug' => $movieDataNomal['slug'],
    //                         'release_year' => $movieDataNomal['year'],
    //                         'poster_url' => $fileName,
    //                         'link_poster_internet' => $movieData['thumb_url'] ?? '',
    //                         'status' => 'Public',
    //                         'description' => $movieData['content'] ?? '',
    //                         'trailer_url' => $movieData['trailer_url'] ?? '',
    //                         'rating' => $movieData['tmdb']['vote_average'] ?? null,
    //                         'views' => $movieData['view'] ?? null,
    //                         'countries' => $movieData['country'][0]['name'] ?? null,
    //                         'duration' => $movieData['time'] ?? null,
    //                         'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',
    //                     ]
    //                 );

    //                 // 🔹 Gắn category (có fallback tự tạo)
    //                 foreach ($movieData['category'] as $category) {
    //                     if (!isset($allCategories[$category['slug']])) {
    //                         $allCategories[$category['slug']] = Category::firstOrCreate(
    //                             ['slug' => $category['slug']],
    //                             ['name' => $category['name']]
    //                         );
    //                     }

    //                     $movie->categories()->syncWithoutDetaching([
    //                         $allCategories[$category['slug']]->id
    //                     ]);
    //                 }

    //                 // 🔹 Lưu tập phim
    //                 $episodesToInsert = [];
    //                 foreach ($episodesData as $episode) {
    //                     foreach ($episode['server_data'] as $ep) {
    //                         $episodeNumber = (count($episode['server_data']) == 1) ? 'Full' : $ep['name'];
    //                         $episodesToInsert[] = [
    //                             'movie_id' => $movie->id,
    //                             'episode_number' => $episodeNumber,
    //                             'title' => "{$movie->title} - {$ep['name']}",
    //                             'link_video_internet' => $ep['link_m3u8'] ?? null,
    //                             'created_at' => now(),
    //                             'updated_at' => now(),
    //                         ];
    //                     }
    //                 }

    //                 if (!empty($episodesToInsert)) {
    //                     Episode::insert($episodesToInsert);
    //                 }

    //                 DB::commit();
    //             } catch (\Throwable $e) {
    //                 DB::rollBack();
    //                 Log::error("Lỗi khi lưu phim: {$e->getMessage()}");
    //             }
    //         },
    //         'rejected' => function ($reason, $index) {
    //             Log::error('Request failed: ' . $reason->getMessage());
    //         },
    //     ]);

    //     $promise = $pool->promise();
    //     $promise->wait();

    //     $executionTime = round(microtime(true) - $startTime, 2);
    //     Log::info("Import xong {$executionTime}s cho " . count($allMovies) . " phim");

    //     return redirect()->back()->with('success', "Leech thành công {$executionTime}s cho " . count($allMovies) . " phim");
    // }



    // // hàm lấy phim không tải ảnh
    // public function importAllMoviesWithEpisodes($slug, Request $request)
    // {
    //     ini_set('max_execution_time', 0);
    //     $startTime = microtime(true);

    //     $leechUrl = LeechMovieUrl::where('slug', $slug)->firstOrFail();
    //     $client = new Client(['timeout' => 15]);

    //     $trangdau = $request->trangdau;
    //     $trangcuoi = $request->trangcuoi;

    //     if ($trangdau > $trangcuoi) {
    //         [$trangdau, $trangcuoi] = [$trangcuoi, $trangdau];
    //     }

    //     $allMovies = [];

    //     // 🔹 Bước 1: Lấy danh sách phim từ tất cả các trang
    //     for ($page = $trangdau; $page <= $trangcuoi; $page++) {
    //         $response = $client->get($leechUrl->url_list_movie . $page);
    //         if ($response->getStatusCode() !== 200) continue;
    //         $data = json_decode($response->getBody(), true);
    //         $movies = $data['items'] ?? [];
    //         $allMovies = array_merge($allMovies, $movies);
    //     }

    //     // 🔹 Bước 2: Chuẩn bị request song song tới API chi tiết phim
    //     $requests = function ($movies) use ($client, $leechUrl) {
    //         foreach ($movies as $movieDataNomal) {
    //             yield function () use ($client, $leechUrl, $movieDataNomal) {
    //                 return $client->getAsync($leechUrl->url_detail . $movieDataNomal['slug'], [
    //                     'meta' => ['movie_basic' => $movieDataNomal]
    //                 ]);
    //             };
    //         }
    //     };

    //     $concurrency = 20; // số lượng request chạy song song
    //     $pool = new Pool($client, $requests($allMovies), [
    //         'concurrency' => $concurrency,
    //         'fulfilled' => function (Response $response, $index) use ($allMovies) {
    //             try {
    //                 $movieDataNomal = $allMovies[$index];
    //                 $detailsData = json_decode($response->getBody(), true);
    //                 $episodesData = $detailsData['episodes'] ?? [];
    //                 $movieData = $detailsData['movie'] ?? null;

    //                 if (!$movieData) {
    //                     Log::warning("Thiếu dữ liệu phim: {$movieDataNomal['slug']}");
    //                     return;
    //                 }

    //                 DB::beginTransaction();

    //                 $movie = Movie::updateOrCreate(
    //                     ['slug' => $movieDataNomal['slug']],
    //                     [
    //                         'title' => $movieDataNomal['name'],
    //                         'slug' => $movieDataNomal['slug'],
    //                         'release_year' => $movieDataNomal['year'],
    //                         'link_poster_internet' => $movieData['thumb_url'] ?? '',
    //                         'status' => 'Public',
    //                         'description' => $movieData['content'] ?? '',
    //                         'trailer_url' => $movieData['trailer_url'] ?? '',
    //                         'rating' => $movieData['tmdb']['vote_average'] ?? null,
    //                         'views' => $movieData['view'] ?? null,
    //                         'countries' => $movieData['country'][0]['name'] ?? null,
    //                         'duration' => $movieData['time'] ?? null,
    //                         'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',
    //                     ]
    //                 );

    //                 // Gắn category
    //                 foreach ($movieData['category'] as $category) {
    //                     $categoryNew = Category::firstOrCreate(
    //                         ['slug' => $category['slug']],
    //                         ['name' => $category['name']]
    //                     );
    //                     $movie->categories()->syncWithoutDetaching([$categoryNew->id]);
    //                 }

    //                 // Lưu tập phim
    //                 $episodesToInsert = [];
    //                 foreach ($episodesData as $episode) {
    //                     foreach ($episode['server_data'] as $ep) {
    //                         $episodeNumber = (count($episode['server_data']) == 1) ? 'Full' : $ep['name'];
    //                         $episodesToInsert[] = [
    //                             'movie_id' => $movie->id,
    //                             'episode_number' => $episodeNumber,
    //                             'title' => "{$movie->title} - {$ep['name']}",
    //                             'link_video_internet' => $ep['link_m3u8'] ?? null,
    //                             'created_at' => now(),
    //                             'updated_at' => now(),
    //                         ];
    //                     }
    //                 }

    //                 if (!empty($episodesToInsert)) {
    //                     Episode::insert($episodesToInsert);
    //                 }

    //                 DB::commit();
    //             } catch (\Throwable $e) {
    //                 DB::rollBack();
    //                 Log::error("Lỗi khi lưu phim: {$e->getMessage()}");
    //             }
    //         },
    //         'rejected' => function (RequestException $reason, $index) use ($allMovies) {
    //             Log::error("Request thất bại cho phim {$allMovies[$index]['slug']}: {$reason->getMessage()}");
    //         },
    //     ]);

    //     $promise = $pool->promise();
    //     $promise->wait();

    //     $executionTime = round(microtime(true) - $startTime, 2);
    //     Log::info("Import xong {$executionTime}s cho " . count($allMovies) . " phim");

    //     return redirect()->back()->with('success', "Leech thành công {$executionTime}s cho " . count($allMovies) . " phim");
    // }



    //// hàm lấy phim kèm tải ảnh
    //     // Đếm số lượng phim xử lý
    //     private int $successCount = 0;
    //     private int $failCount = 0;

    //     public function importAllMoviesWithEpisodes($slug, Request $request)
    //     {
    //         ini_set('max_execution_time', 0);
    //         $startTime = microtime(true);

    //         $leechUrl = LeechMovieUrl::where('slug', $slug)->firstOrFail();
    //         $client = new Client(['timeout' => 15]);

    //         [$trangdau, $trangcuoi] = $this->normalizePageRange($request->trangdau, $request->trangcuoi);

    //         // 🔹 Bước 1: Lấy danh sách phim
    //         $allMovies = $this->fetchAllMovies($client, $leechUrl, $trangdau, $trangcuoi);

    //         // 🔹 Bước 2: Lấy chi tiết & lưu phim + tập
    //         $this->fetchAndSaveMovieDetails($client, $leechUrl, $allMovies);

    //         $executionTime = round(microtime(true) - $startTime, 2);
    //         Log::info("Import hoàn tất: {$executionTime}s — Thành công: {$this->successCount}, Thất bại: {$this->failCount}");

    //         return redirect()->back()->with('success',
    //             "Leech thành công {$executionTime}s. Thành công: {$this->successCount}, Thất bại: {$this->failCount}"
    //         );
    //     }

    //     // -------------------------------------------
    //     // 🔸 Hàm con 1: Chuẩn hóa khoảng trang
    //     // -------------------------------------------
    //     private function normalizePageRange($trangdau, $trangcuoi)
    //     {
    //         if ($trangdau > $trangcuoi) {
    //             [$trangdau, $trangcuoi] = [$trangcuoi, $trangdau];
    //         }
    //         return [$trangdau, $trangcuoi];
    //     }

    //     // -------------------------------------------
    //     // 🔸 Hàm con 2: Lấy danh sách phim
    //     // -------------------------------------------
    //     private function fetchAllMovies($client, $leechUrl, $trangdau, $trangcuoi)
    //     {
    //         $allMovies = [];

    //         for ($page = $trangdau; $page <= $trangcuoi; $page++) {
    //             try {
    //                 $response = $client->get($leechUrl->url_list_movie . $page);
    //                 if ($response->getStatusCode() !== 200) continue;

    //                 $data = json_decode($response->getBody(), true);
    //                 $movies = $data['items'] ?? [];
    //                 $allMovies = array_merge($allMovies, $movies);
    //             } catch (\Throwable $e) {
    //                 Log::error("Lỗi khi lấy danh sách trang {$page}: " . $e->getMessage());
    //             }
    //         }

    //         return $allMovies;
    //     }

    //     // -------------------------------------------
    //     // 🔸 Hàm con 3: Lấy chi tiết và lưu dữ liệu
    //     // -------------------------------------------
    //     private function fetchAndSaveMovieDetails($client, $leechUrl, $allMovies)
    // {
    //     $maxRetries = 3;
    //     $requests = function ($movies) use ($client, $leechUrl) {
    //         foreach ($movies as $movieDataNomal) {
    //             yield function () use ($client, $leechUrl, $movieDataNomal) {
    //                 return $client->getAsync($leechUrl->url_detail . $movieDataNomal['slug'], [
    //                     'meta' => ['movie_basic' => $movieDataNomal]
    //                 ]);
    //             };
    //         }
    //     };

    //     $pool = new Pool($client, $requests($allMovies), [
    //         'concurrency' => 20,

    //         'fulfilled' => function (Response $response, $index) use ($allMovies, $client, $leechUrl, $maxRetries) {
    //             $success = $this->saveMovieData($response, $allMovies[$index]);

    //             if (!$success) {
    //                 $movie = $allMovies[$index];
    //                 Log::warning("❌ Lưu phim thất bại: {$movie['slug']} — sẽ thử lại...");
    //                 $this->retryRequest($client, $leechUrl, $movie, $maxRetries);
    //             } else {
    //                 $this->successCount++;
    //             }
    //         },

    //         'rejected' => function ($reason, $index) use ($allMovies, $client, $leechUrl, $maxRetries) {
    //             $movie = $allMovies[$index];
    //             Log::warning("⚠️ Request thất bại cho phim {$movie['slug']} — {$reason->getMessage()}");

    //             $this->retryRequest($client, $leechUrl, $movie, $maxRetries);
    //         },
    //     ]);

    //     $pool->promise()->wait();
    // }
    // private function retryRequest($client, $leechUrl, $movie, $maxRetries)
    // {
    //     for ($retry = 1; $retry <= $maxRetries; $retry++) {
    //         try {
    //             sleep(2); // chờ 2 giây giữa các lần thử
    //             $response = $client->get($leechUrl->url_detail . $movie['slug']);
    //             $success = $this->saveMovieData($response, $movie);

    //             if ($success) {
    //                 Log::info("✅ Thử lại lần $retry thành công cho phim {$movie['slug']}");
    //                 $this->successCount++;

    //                 return;
    //             }

    //         } catch (\Throwable $e) {
    //             Log::error("❌ Lần thử $retry thất bại cho phim {$movie['slug']}: {$e->getMessage()}");
    //         }
    //     }

    //     Log::error("🚫 Tất cả các lần thử đều thất bại cho phim {$movie['slug']}");
    //     $this->failCount++;
    // }


    //     // -------------------------------------------
    //     // 🔸 Hàm con 4: Xử lý & lưu dữ liệu phim
    //     // -------------------------------------------
    //     private function saveMovieData(Response $response, $movieDataNomal): bool
    //     {
    //         try {
    //             $detailsData = json_decode($response->getBody(), true);
    //             $episodesData = $detailsData['episodes'] ?? [];
    //             $movieData = $detailsData['movie'] ?? null;

    //             if (!$movieData) {
    //                 Log::warning("Thiếu dữ liệu phim: {$movieDataNomal['slug']}");
    //                 return false;
    //             }

    //             DB::beginTransaction();

    //             // Lưu ảnh
    //             $fileName = $this->savePosterImage($movieData['thumb_url']);

    //             // Lưu phim
    //             $movie = $this->saveMovie($movieDataNomal, $movieData, $fileName);

    //             // Gắn category
    //             $this->attachCategories($movie, $movieData['category']);

    //             // Lưu tập
    //             $this->saveEpisodes($movie, $episodesData);

    //             DB::commit();
    //             return true;
    //         } catch (\Throwable $e) {
    //             DB::rollBack();
    //             Log::error("Lỗi khi lưu phim: {$e->getMessage()}");
    //             return false;
    //         }
    //     }

    //     // -------------------------------------------
    //     // 🔸 Hàm con 5: Lưu ảnh poster
    //     // -------------------------------------------
    //     private function savePosterImage($thumbUrl)
    //     {
    //         $posterFilm = file_get_contents($thumbUrl);
    //         $fileName = basename($thumbUrl);
    //         Storage::put('public/images/' . $fileName, $posterFilm);
    //         return $fileName;
    //     }

    //     // -------------------------------------------
    //     // 🔸 Hàm con 6: Lưu phim
    //     // -------------------------------------------
    //     private function saveMovie($movieDataNomal, $movieData, $fileName)
    //     {
    //         return Movie::updateOrCreate(
    //             ['slug' => $movieDataNomal['slug']],
    //             [
    //                 'title' => $movieDataNomal['name'],
    //                 'slug' => $movieDataNomal['slug'],
    //                 'release_year' => $movieDataNomal['year'],
    //                 'poster_url' => $fileName,
    //                 'link_poster_internet' => $movieData['thumb_url'] ?? '',
    //                 'status' => 'Public',
    //                 'description' => $movieData['content'] ?? '',
    //                 'trailer_url' => $movieData['trailer_url'] ?? '',
    //                 'rating' => $movieData['tmdb']['vote_average'] ?? null,
    //                 'views' => $movieData['view'] ?? null,
    //                 'countries' => $movieData['country'][0]['name'] ?? null,
    //                 'duration' => $movieData['time'] ?? null,
    //                 'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',
    //             ]
    //         );
    //     }

    //     // -------------------------------------------
    //     // 🔸 Hàm con 7: Gắn category
    //     // -------------------------------------------
    //     private function attachCategories($movie, $categories)
    //     {
    //         foreach ($categories as $category) {
    //             $categoryNew = Category::firstOrCreate(
    //                 ['slug' => $category['slug']],
    //                 ['name' => $category['name']]
    //             );
    //             $movie->categories()->syncWithoutDetaching([$categoryNew->id]);
    //         }
    //     }

    //     // -------------------------------------------
    //     // 🔸 Hàm con 8: Lưu tập phim
    //     // -------------------------------------------
    //     private function saveEpisodes($movie, $episodesData)
    //     {
    //         $episodesToInsert = [];

    //         foreach ($episodesData as $episode) {
    //             foreach ($episode['server_data'] as $ep) {
    //                 $episodeNumber = (count($episode['server_data']) == 1) ? 'Full' : $ep['name'];
    //                 $episodesToInsert[] = [
    //                     'movie_id' => $movie->id,
    //                     'episode_number' => $episodeNumber,
    //                     'title' => "{$movie->title} - {$ep['name']}",
    //                     'link_video_internet' => $ep['link_m3u8'] ?? null,
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ];
    //             }
    //         }

    //         if (!empty($episodesToInsert)) {
    //             Episode::insert($episodesToInsert);
    //         }
    //     }








    public function importMovieDetails($slug, $movie)
    {
        $leechUrl = LeechMovieUrl::where('slug', $slug)->first();
        $url =  $leechUrl->url_detail . $movie; // Thay bằng API chi tiết phim thực tế
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $movieData = $data['movie'];
            $episodesData = $data['episodes'];

            // Lưu ảnh vào storage
            $posterFilm = file_get_contents($movieData['thumb_url']);
            $fileName = basename($movieData['thumb_url']);
            Storage::put('public/images/' . $fileName, $posterFilm);

            // Lưu hoặc cập nhật thông tin phim
            $movie = Movie::updateOrCreate(
                ['slug' => $movieData['slug']], // Kiểm tra trùng lặp dựa trên slug
                [
                    'title' => $movieData['name'],
                    'slug' => $movieData['slug'],
                    'release_year' => $movieData['year'],
                    'description' => $movieData['content'] ?? '',
                    'poster_url' => $fileName,
                    'link_poster_internet' =>  $movieData['thumb_url'] ?? '',
                    'trailer_url' => $movieData['trailer_url'] ?? '',
                    'rating' => $movieData['tmdb']['vote_average'],
                    'director' => isset($movieData['directors']) ? implode(', ', $movieData['directors']) : '',
                    'countries' => $movieData['country'][0]['name'],
                    'duration' => $movieData['time'],
                    'status' => 'Public', // Có thể tuỳ chỉnh
                    'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',  // Tự đặt giá trị
                ]
            );

            foreach ($movieData['category'] as $category) {
                $categoryNew = Category::firstOrCreate(
                    ['slug' => $category['slug']],
                    [
                        'name' => $category['name']
                    ]
                );
                // $movie_category_id = Movie::find($movie->id);
                $movie->categories()->attach($categoryNew->id);
            }
            // Lưu thông tin các tập phim
            foreach ($episodesData as $episode) {
                foreach ($episode['server_data'] as $ep) {
                    if (count($episode['server_data']) == 1) {
                        Episode::updateOrCreate(
                            [
                                'movie_id' => $movie->id,
                                'episode_number' => 1,
                            ],
                            [
                                'title' => "{$movie->title} - Tập {$ep['name']}",
                                'link_video_internet' => $ep['link_m3u8'] ?? null,
                                // 'video_url' => $ep['link_m3u8'] ?? null,
                            ]
                        );
                    } else {
                        Episode::updateOrCreate(
                            [
                                'movie_id' => $movie->id,
                                'episode_number' => $ep['name']
                            ],
                            [
                                'title' => "{$movie->title} - Tập {$ep['name']}",
                                'link_video_internet' => $ep['link_m3u8'] ?? null,
                                // 'video_url' => $ep['link_m3u8'] ?? null,
                            ]
                        );
                    }
                }
            }

            return redirect()->back()->with('success', 'Leech phim thành công');
        }
        return 'Failed to fetch movie details.';
    }
    public function importMovieDetailsBySlug(Request $request)
    {
        $url =  $request->slug; // Thay bằng API chi tiết phim thực tế

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $movieData = $data['movie'];
            $episodesData = $data['episodes'];

            // Lưu hoặc cập nhật thông tin phim
            $posterFilm = file_get_contents($movieData['thumb_url']);
            $fileName = basename($movieData['thumb_url']);
            Storage::put('public/images/' . $fileName, $posterFilm);
            $movie = Movie::updateOrCreate(
                ['slug' => $movieData['slug']], // Kiểm tra trùng lặp dựa trên slug
                [
                    'title' => $movieData['name'],
                    'slug' => $movieData['slug'],
                    'release_year' => $movieData['year'],
                    'description' => $movieData['content'] ?? '',
                    'poster_url' => $fileName,
                    'link_poster_internet' =>  $movieData['thumb_url'] ?? '',
                    'trailer_url' => $movieData['trailer_url'] ?? '',
                    'rating' => $movieData['tmdb']['vote_average'],
                    'director' => isset($movieData['directors']) ? implode(', ', $movieData['directors']) : '',
                    'countries' => $movieData['country'][0]['name'],
                    'duration' => $movieData['time'],
                    'status' => 'Public', // Có thể tuỳ chỉnh
                    'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',  // Tự đặt giá trị
                ]
            );

            // Thêm danh mục và liên kết đến phim qua bảng Category_movie
            foreach ($movieData['category'] as $category) {
                $categoryNew = Category::firstOrCreate(
                    ['slug' => $category['slug']],
                    [
                        'name' => $category['name']
                    ]
                );
                // $movie_category_id = Movie::find($movie->id);
                $movie->categories()->attach($categoryNew->id);
            }
            // Lưu thông tin các tập phim
            foreach ($episodesData as $episode) {
                foreach ($episode['server_data'] as $ep) {
                    if (count($episode['server_data']) == 1) {
                        Episode::updateOrCreate(
                            [
                                'movie_id' => $movie->id,
                                'episode_number' => 1,
                            ],
                            [
                                'title' => "{$movie->title} - Tập {$ep['name']}",
                                'link_video_internet' => $ep['link_m3u8'] ?? null,
                                // 'video_url' => $ep['link_m3u8'] ?? null,
                            ]
                        );
                    } else {
                        Episode::updateOrCreate(
                            [
                                'movie_id' => $movie->id,
                                'episode_number' => preg_replace('/^0+/', '', preg_replace('/\D/', '', $ep['name']))
                            ],
                            [
                                'title' => "{$movie->title} - Tập {$ep['name']}",
                                'link_video_internet' => $ep['link_m3u8'] ?? null,
                                // 'video_url' => $ep['link_m3u8'] ?? null,
                            ]
                        );
                    }
                }
            }

            return redirect()->back()->with('success', 'Leech phim thành công');
        }
        return 'Failed to fetch movie details.';
    }
}
