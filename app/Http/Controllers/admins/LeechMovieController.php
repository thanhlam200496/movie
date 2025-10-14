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

                    // Lưu tập phim
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




// hàm của AI
// public function importAllMoviesWithEpisodes($slug, Request $request)
// {
//     ini_set('max_execution_time', 0);
//     $startTime = microtime(true);

//     $leechUrl = LeechMovieUrl::where('slug', $slug)->firstOrFail();

//     // Tạo client với retry middleware để đảm bảo dữ liệu
//     $handlerStack = HandlerStack::create();
//     $handlerStack->push(\GuzzleHttp\Middleware::retry(function ($retries, $request, $response, $exception) {
//         return $retries < 3 && ($exception || ($response && $response->getStatusCode() !== 200));
//     }));
//     $client = new Client([
//         'timeout' => 15,
//         'handler' => $handlerStack,
//     ]);

//     $trangdau = $request->trangdau;
//     $trangcuoi = $request->trangcuoi;

//     if ($trangdau > $trangcuoi) {
//         [$trangdau, $trangcuoi] = [$trangcuoi, $trangdau];
//     }

//     // Checkpoint: Lưu tiến độ trong Cache
//     $cacheKey = "crawl_progress_{$slug}";
//     $progress = Cache::get($cacheKey, ['last_page' => $trangdau - 1, 'processed_movies' => 0]);
//     $startPage = max($trangdau, $progress['last_page'] + 1);
//     $processedMovies = $progress['processed_movies'];

//     $allMovies = [];
//     $concurrencyPages = 10; // Song song lấy danh sách trang

//     // 🔹 Bước 1: Lấy danh sách phim song song từ các trang
//     $pageMap = []; // Lưu ánh xạ index => page
//     $requestsPages = function ($startPage, $trangcuoi) use ($client, $leechUrl, &$pageMap) {
//         $index = 0;
//         for ($page = $startPage; $page <= $trangcuoi; $page++) {
//             $pageMap[$index] = $page; // Lưu page cho index
//             yield function () use ($client, $leechUrl, $page) {
//                 return $client->getAsync($leechUrl->url_list_movie . $page);
//             };
//             $index++;
//         }
//     };

//     $poolPages = new Pool($client, $requestsPages($startPage, $trangcuoi), [
//         'concurrency' => $concurrencyPages,
//         'fulfilled' => function (Response $response, $index) use (&$allMovies, $pageMap, $cacheKey) {
//             $page = isset($pageMap[$index]) ? $pageMap[$index] : 'unknown'; // Kiểm tra index tồn tại
//             try {
//                 $data = json_decode($response->getBody(), true);
//                 $movies = $data['items'] ?? [];
//                 $allMovies = array_merge($allMovies, $movies);
//                 Cache::put($cacheKey, ['last_page' => $page, 'processed_movies' => count($allMovies)], now()->addHours(24));
//                 Log::info("Đã lấy danh sách phim từ trang {$page}");
//             } catch (\Throwable $e) {
//                 Log::error("Lỗi xử lý dữ liệu trang {$page}: {$e->getMessage()}");
//             }
//         },
//         'rejected' => function ($reason, $index) use ($pageMap) {
//             $page = isset($pageMap[$index]) ? $pageMap[$index] : 'unknown';
//             Log::error("Lấy danh sách trang {$page} thất bại: " . $reason->getMessage());
//         },
//     ]);

//     $poolPages->promise()->wait();

//     if (empty($allMovies)) {
//         return redirect()->back()->with('error', 'Không lấy được danh sách phim.');
//     }

//     // 🔹 Bước 2: Thu thập categories trước để giảm query
//     $allCategories = collect($allMovies)->flatMap(function ($movie) {
//         return $movie['category'] ?? [];
//     })->unique('slug')->map(function ($cat) {
//         return Category::firstOrCreate(['slug' => $cat['slug']], ['name' => $cat['name']]);
//     })->keyBy('slug');

//     // 🔹 Bước 3: Xử lý phim theo lô để giảm bộ nhớ
//     $batchSize = 1000;
//     $concurrencyDetails = 20;
//     $totalMovies = count($allMovies);
//     $movieCategoryRelations = []; // Thu thập quan hệ category để insert hàng loạt

//     for ($i = $processedMovies; $i < $totalMovies; $i += $batchSize) {
//         $batch = array_slice($allMovies, $i, $batchSize);

//         // Chuẩn bị request song song cho chi tiết phim
//         $requestsDetails = function ($batch) use ($client, $leechUrl) {
//             foreach ($batch as $index => $movieDataNomal) {
//                 yield function () use ($client, $leechUrl, $movieDataNomal) {
//                     return $client->getAsync($leechUrl->url_detail . $movieDataNomal['slug'], [
//                         'meta' => ['movie_basic' => $movieDataNomal]
//                     ]);
//                 };
//             }
//         };

//         $poolDetails = new Pool($client, $requestsDetails($batch), [
//             'concurrency' => $concurrencyDetails,
//             'fulfilled' => function (Response $response, $index) use ($batch, $allCategories, &$movieCategoryRelations, $client, $cacheKey) { // Thêm $cacheKey vào use
//                 try {
//                     $movieDataNomal = $batch[$index];
//                     $detailsData = json_decode($response->getBody(), true);
//                     $episodesData = $detailsData['episodes'] ?? [];
//                     $movieData = $detailsData['movie'] ?? null;

//                     if (!$movieData) {
//                         Log::warning("Thiếu dữ liệu phim: {$movieDataNomal['slug']}");
//                         return;
//                     }

//                     DB::beginTransaction();

//                     // Tải ảnh bất đồng bộ để giảm thời gian blocking
//                     $fileName = '';
//                     if (!empty($movieData['thumb_url'])) {
//                         try {
//                             $posterResponse = $client->get($movieData['thumb_url']);
//                             $fileName = md5($movieData['thumb_url']) . '_' . basename($movieData['thumb_url']);
//                             $posterFilm = $posterResponse->getBody()->getContents();
//                             Storage::put('public/images/' . $fileName, $posterFilm);
//                         } catch (\Throwable $e) {
//                             Log::warning("Lỗi tải ảnh cho phim {$movieDataNomal['slug']}: {$e->getMessage()}");
//                             $fileName = 'default.jpg'; // Đảm bảo toàn vẹn bằng ảnh mặc định
//                         }
//                     } else {
//                         $fileName = 'default.jpg'; // Ảnh mặc định nếu không có thumb_url
//                     }

//                     // Lưu phim
//                     $movie = Movie::updateOrCreate(
//                         ['slug' => $movieDataNomal['slug']],
//                         [
//                             'title' => $movieDataNomal['name'],
//                             'slug' => $movieDataNomal['slug'],
//                             'release_year' => $movieDataNomal['year'],
//                             'poster_url' => $fileName,
//                             'link_poster_internet' => $movieData['thumb_url'] ?? '',
//                             'status' => 'Public',
//                             'description' => $movieData['content'] ?? '',
//                             'trailer_url' => $movieData['trailer_url'] ?? '',
//                             'rating' => $movieData['tmdb']['vote_average'] ?? null,
//                             'views' => $movieData['view'] ?? null,
//                             'countries' => $movieData['country'][0]['name'] ?? null,
//                             'duration' => $movieData['time'] ?? null,
//                             'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',
//                         ]
//                     );

//                     // Thu thập quan hệ category
//                     foreach ($movieData['category'] as $category) {
//                         if (isset($allCategories[$category['slug']])) {
//                             $movieCategoryRelations[] = [
//                                 'movie_id' => $movie->id,
//                                 'category_id' => $allCategories[$category['slug']]->id,
//                             ];
//                         }
//                     }

//                     // Lưu tập phim ngay để giảm bộ nhớ
//                     $episodesToInsert = [];
//                     foreach ($episodesData as $episode) {
//                         foreach ($episode['server_data'] as $ep) {
//                             $episodeNumber = (count($episode['server_data']) == 1) ? 'Full' : $ep['name'];
//                             $episodesToInsert[] = [
//                                 'movie_id' => $movie->id,
//                                 'episode_number' => $episodeNumber,
//                                 'title' => "{$movie->title} - {$ep['name']}",
//                                 'link_video_internet' => $ep['link_m3u8'] ?? null,
//                                 'created_at' => now(),
//                                 'updated_at' => now(),
//                             ];
//                         }
//                     }

//                     if (!empty($episodesToInsert)) {
//                         Episode::insert($episodesToInsert);
//                     }

//                     DB::commit();

//                     // Cập nhật tiến độ
//                     Cache::increment($cacheKey . '_processed_movies');
//                     Log::info("Đã xử lý phim: {$movieDataNomal['slug']} ({$index}/" . count($batch) . " trong lô)");

//                 } catch (\Throwable $e) {
//                     DB::rollBack();
//                     Log::error("Lỗi khi lưu phim {$movieDataNomal['slug']}: {$e->getMessage()}");
//                 }
//             },
//             'rejected' => function ($reason, $index) use ($batch) {
//                 $movieDataNomal = $batch[$index] ?? ['slug' => 'unknown'];
//                 Log::error("Request chi tiết phim thất bại cho {$movieDataNomal['slug']}: " . $reason->getMessage());
//             },
//         ]);

//         $poolDetails->promise()->wait();
//     }

//     // 🔹 Bước 4: Insert hàng loạt quan hệ movie-category
//     if (!empty($movieCategoryRelations)) {
//         DB::table('movie_category')->insertOrIgnore($movieCategoryRelations); // Giả sử bảng pivot là movie_category
//     }

//     // Xóa checkpoint sau khi hoàn tất
//     Cache::forget($cacheKey);

//     $executionTime = round(microtime(true) - $startTime, 2);
//     Log::info("Import xong {$executionTime}s cho {$totalMovies} phim");

//     return redirect()->back()->with('success', "Leech thành công {$executionTime}s cho {$totalMovies} phim");
// }








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
