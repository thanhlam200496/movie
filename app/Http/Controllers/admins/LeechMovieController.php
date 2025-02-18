<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Episode;
use App\Models\LeechMovieUrl;
use App\Models\Movie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $leechUrl=LeechMovieUrl::where('slug',$slug)->first();
        $client = new Client();
        $trangdau = $request->trangdau;
        $trangcuoi = $request->trangcuoi;
        if ($trangdau > $trangcuoi) {
            $temp = $trangdau;
            $trangdau = $trangcuoi;
            $trangcuoi = $temp;
        }
        $page = $trangdau;

        do {
            $response = $client->get($leechUrl->url_list_movie.$page);

            if ($response->getStatusCode() !== 200) {
                return response()->json(['message' => "Failed to fetch data on page $page"], 500);
            }

            $data = json_decode($response->getBody(), true);
            $movies = $data['items'];
            $totalPages = $data['pagination']['totalPages'] ?? 1;

            foreach ($movies as $movieDataNomal) {
                DB::beginTransaction(); // Bắt đầu transaction cho mỗi phim

                try {
                    // Lưu hoặc lấy phim từ cơ sở dữ liệu


                    // Gọi API chi tiết phim
                    $detailsResponse = Http::get($leechUrl->url_detail . $movieDataNomal['slug']);
                    if ($detailsResponse->successful()) {
                        $detailsData = $detailsResponse->json();
                        $episodesData = $detailsData['episodes'];
                        $movieData = $detailsData['movie'];
                        
                        $movie = Movie::updateOrCreate(
                            ['slug' => $movieDataNomal['slug']],
                            [
                                'title' => $movieDataNomal['name'],
                                'slug' => $movieDataNomal['slug'],
                                'release_year' => $movieDataNomal['year'],
                                // 'description' => $movieData['description'] ?? '',
                                'link_poster_internet' =>  ($movieData['thumb_url'] ?? ''),
                                // 'trailer_url' => $movieData['trailer_url'] ?? '',
                                // 'rating' => 9, // Tuỳ chỉnh nếu cần
                                // 'director' => isset($movieData['directors']) ? implode(', ', $movieData['directors']) : '',
                                // 'countries' => isset($movieData['countries']) ? implode(', ', $movieData['countries']) : '',

                                'status' => 'Public',

                                'description' => $movieData['content'] ?? '',

                                'trailer_url' => $movieData['trailer_url'] ?? '',
                                'rating' => $movieData['tmdb']['vote_average'], // Tuỳ chỉnh nếu cần
                                'views' => $movieData['view'],
                                'countries' => $movieData['country'][0]['name'],
                                'duration' => 100,

                                'type_film' => $movieData['episode_current'] == 'Full' ? 'Movie' : 'TV Show',
                            ]
                        );

                        // tạo category nếu chưa có và liên kết đến phim

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
                        // Lưu tập phim
                        foreach ($episodesData as $episode) {
                            foreach ($episode['server_data'] as $ep) {
                                if (count($episode['server_data']) == 1) {
                                    Episode::updateOrCreate(
                                        [
                                            'movie_id' => $movie->id,
                                            'episode_number' => 'Full',
                                        ],
                                        [
                                            'title' => "{$movie->title} - {$ep['name']}",
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
                                            'title' => "{$movie->title} - {$ep['name']}",
                                            'link_video_internet' => $ep['link_m3u8'] ?? null,
                                            // 'video_url' => $ep['link_m3u8'] ?? null,
                                        ]
                                    );
                                }
                            }
                        }
                    }

                    DB::commit(); // Commit dữ liệu
                } catch (\Exception $e) {
                    DB::rollback(); // Rollback nếu có lỗi
                    return response()->json(['message' => "Failed to save movie {$movieData['name']}: {$e->getMessage()}"], 500);
                }
            }

            $page++;
        } while (
            $page <=
            $trangcuoi
        ); // Có thể thay thế 6 bằng tổng số trang thực tế

        return redirect()->back()->with('success', 'Leech phim thành công');
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
                    'duration' => 100,
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
                    'duration' => 100,
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
