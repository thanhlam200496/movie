<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    function show($slug, $episode = null)
    {

        $userId = auth()->check() ? auth()->user()->id : 1;

        // Lấy watched_duration từ bảng view_history mà không cần định nghĩa quan hệ
        $watched_duration = DB::table('view_history')
            ->where('user_id', $userId)
            ->where('episode_id', $episode)
            ->value('watched_duration') ?? 0;

        // Lấy movie với các liên kết categories và episodes
        $movie = Movie::with(['categories', 'episodes'])
            ->where('slug', $slug)->first();
        $listWatched = DB::table('view_history')
            ->where('user_id', $userId)->get();;
        $episodeId = $episode ?? null;

        if ($episodeId) {
            $episode = Episode::where(['movie_id' => $movie->id, 'id' => $episodeId])->first();
        } else {
            $episode = $movie->episodes[0];
        }

        $comments = Comment::where(['episode_id' => $episode->id])->get();

        $totalEpisode = DB::table('episodes')
    ->where('movie_id', $movie->id)
    ->count('id');
        // dd($comments);
        // dd($episode);
        return view('client_movie.detail', [
            'movie' => $movie,
            'totalEpisode'=>$totalEpisode,
            'episode' => $episode,
            'comments' => $comments,
            'watched_duration' => $watched_duration,
            'listWatched' => $listWatched
        ]);
    }
    public function ajaxEpisode($id)
    {
        $episode = Episode::find($id);
        $userId = auth()->check() ? auth()->user()->id : 1;

        if (!$episode) {
            return response()->json(['error' => 'Không tìm thấy tập phim'], 404);
        }
        // Lấy watched_duration từ bảng view_history mà không cần định nghĩa quan hệ
        $watched_duration = DB::table('view_history')
            ->where('user_id', $userId)
            ->where('episode_id', $episode->id)
            ->value('watched_duration') ;

        return response()->json([
            'id' => $episode->id,
            'userid'=>$userId,
            'title' => $episode->title,
            'watched_duration' => $watched_duration,
            'type' => $episode->link_video_internet ? 'hls' : 'mp4',
            'video_url' => $episode->link_video_internet
                ? $episode->link_video_internet
                : asset('storage/videos/' . $episode->video_url),
        ]);
    }
}
