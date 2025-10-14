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



class LeechMovieController extends Controller
{
    public function getMovies($slug,Request $request)
    {
        $leechUrl=LeechMovieUrl::where('slug',$slug)->first();
        $client = new Client();
        $page = $request->page ?? 1;
        $apiUrl=$leechUrl->url_list_movie;
        $response = $client->get($apiUrl . $page);

        // Kiểm tra nếu gọi thành công
        if ($response->getStatusCode() === 200) {
            $movies = json_decode($response->getBody(), true); // Chuyển JSON thành mảng PHP
            // dd($movies);
            // Trả về kết quả hoặc xử lý dữ liệu
            return view('admin_movie.leech_movie.list', ['movies' => $movies['items'],'leechUrl'=>$leechUrl, 'pagination' => $movies['pagination']]);
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
            yield function() use ($client, $leechUrl, $movieDataNomal) {
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

                $movie = Movie::updateOrCreate(
                    ['slug' => $movieDataNomal['slug']],
                    [
                        'title' => $movieDataNomal['name'],
                        'slug' => $movieDataNomal['slug'],
                        'release_year' => $movieDataNomal['year'],
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
        'rejected' => function (RequestException $reason, $index) use ($allMovies) {
            Log::error("Request thất bại cho phim {$allMovies[$index]['slug']}: {$reason->getMessage()}");
        },
    ]);

    $promise = $pool->promise();
    $promise->wait();

    $executionTime = round(microtime(true) - $startTime, 2);
    Log::info("Import xong {$executionTime}s cho " . count($allMovies) . " phim");

    return redirect()->back()->with('success', "Leech thành công {$executionTime}s cho " . count($allMovies) . " phim");
}






    public function importMovieDetails($slug, $movie)
    {
        $leechUrl=LeechMovieUrl::where('slug',$slug)->first();
        $url =  $leechUrl->url_detail.$movie; // Thay bằng API chi tiết phim thực tế
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $movieData = $data['movie'];
            $episodesData = $data['episodes'];

            // Lưu hoặc cập nhật thông tin phim
            $movie = Movie::updateOrCreate(
                ['slug' => $movieData['slug']], // Kiểm tra trùng lặp dựa trên slug
                [
                    'title' => $movieData['name'],
                    'slug' => $movieData['slug'],
                    'release_year' => $movieData['year'],
                    'description' => $movieData['content'] ?? '',
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
            // foreach ($movieData['category'] as $category) {
            //     Category::firstOrCreate(
            //         ['slug'=>$category['slug']],[
            //             'name'=>$category['name']
            //         ]
            //     );
            // }
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
		Storage::put('public/images/'.$fileName, $posterFilm);
            $movie = Movie::updateOrCreate(
                ['slug' => $movieData['slug']], // Kiểm tra trùng lặp dựa trên slug
                [
                    'title' => $movieData['name'],
                    'slug' => $movieData['slug'],
                    'release_year' => $movieData['year'],
                    'description' => $movieData['content'] ?? '',
			'poster_url'=>$fileName,
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
