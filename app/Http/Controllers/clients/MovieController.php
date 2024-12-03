<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    function show($id, Request $request)
    {

        // if (auth()->check()) {
        //     $userId = auth()->user()->id ?? 1; // Mặc định user_id là 1 nếu không có chức năng auth
        //     $watchedDuration = DB::table('view_history')
        //         ->where('user_id', $userId)
        //         ->where('movie_id', $id)
        //         ->value('watched_duration'); // Lấy watched_duration từ bảng view_history
        // }
        // $movie = Movie::with('categories')->with('episodes')->where('id',$id)->first();
        // // $movie->views = $movie->views += 1;
        // // $movie->save();
        // // dd(
        // //     $movie
        // // );
        // if ($request->has('episode_number')) {
        //     $episode=Episode::where(['movie_id'=>$movie->id,'episode_number'=>$request->episode_number])->get();
        // }else {
        //     $episode=$movie->episodes[0];
        // }
        // // dd($episode);
        // return view('client_movie.detail', [
        //     'movie' => $movie,
        //     'episode' => $episode,

        //     'watchedDuration' => $watchedDuration ?? 0 // Nếu không có lịch sử xem thì mặc định là 0
        // ]);
        // // $movie=Movie::find($id);
        // // return view('client_movie.detail',compact('movie'));
        $userId = auth()->check() ? auth()->user()->id : 1;

    // Lấy watched_duration từ bảng view_history mà không cần định nghĩa quan hệ
    $watchedDuration = DB::table('view_history')
        ->where('user_id', $userId)
        ->where('movie_id', $id)
        ->value('watched_duration') ?? 0;

    // Lấy movie với các liên kết categories và episodes
    $movie = Movie::with(['categories', 'episodes'])
        ->findOrFail($id);

    // Lựa chọn episode dựa vào request hoặc lấy tập đầu tiên
    $episode = $request->has('episode_number')
        ? Episode::where('movie_id', $movie->id)
                 ->where('episode_number', $request->episode_number)
                 ->firstOrFail()
        : $movie->episodes->first();

    return view('client_movie.detail', [
        'movie' => $movie,
        'episode' => $episode,
        'watchedDuration' => $watchedDuration
    ]);
    }
}
