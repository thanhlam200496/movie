<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    function index($movie_id)
    {
        $episodes = Episode::where('movie_id', $movie_id)->paginate(5);
        return view('admin_movie.movies.episodes.index', compact('episodes', 'movie_id'));
    }
    function create($movie_id)
    {

        $movie = Movie::find($movie_id);
        // dd($movie);
        return view('admin_movie.movies.episodes.create', compact('movie'));
    }
    function store($movie_id, Request $request)
    {
        $data = [
            'movie_id' => $movie_id,
            'title' => $request->title,
            'episode_number' => $request->episode_number
        ];
        if (isset($request->link_video_internet)) {
            $data['link_video_internet'] = $request->link_video_internet;
        } else {
            $data['video_url'] = $request->video_url;
        }
        Episode::create($data);
        return redirect()->route('admin.episode.index', $movie_id)->with('success', 'Thêm tập phim thành công');
    }
    function destroy(Episode $episode) {
        $episode->delete();
        return redirect()->back()->with('success', 'xóa tập phim thành công');
        
    }
    function show($movie_id, $episode_id) {
        $movie = Movie::find($movie_id);
       $episode=Episode::find($episode_id);
        return view('admin_movie.movies.episodes.show', compact('movie_id','movie','episode'));
    }
    function update($movie_id, $episode_id, Request $request) {
        $data = [
            'movie_id' => $movie_id,
            'title' => $request->title,
            'episode_number' => $request->episode_number
        ];
        if (isset($request->link_video_internet)) {
            $data['link_video_internet'] = $request->link_video_internet;
        } else {
            $data['video_url'] = $request->video_url;
        }
        $episode=Episode::where('id',$episode_id)->update($data);
        return redirect()->route('admin.episode.index', $movie_id)->with('success', 'Thêm tập phim thành công');
    }
}
