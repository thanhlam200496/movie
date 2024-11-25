<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    function show($id)
    {

        if (auth()->check()) {
            $userId = auth()->user()->id ?? 1; // Mặc định user_id là 1 nếu không có chức năng auth
            $watchedDuration = DB::table('view_history')
                ->where('user_id', $userId)
                ->where('movie_id', $id)
                ->value('watched_duration'); // Lấy watched_duration từ bảng view_history
        }
        $movie = Movie::findOrFail($id);
        $movie->views = $movie->views += 1;
        $movie->save();
        return view('client_movie.detail', [
            'movie' => $movie,
            'watchedDuration' => $watchedDuration ?? 0 // Nếu không có lịch sử xem thì mặc định là 0
        ]);
        // $movie=Movie::find($id);
        // return view('client_movie.detail',compact('movie'));
    }
}
