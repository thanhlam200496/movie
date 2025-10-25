<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function test()
    {
        return view('client_movie.home');
    }
    public function home(Request $request)
    {
        $moviesPopular = Movie::with(['categories', 'episodes'])->where(['status' => 'Public'])->orderBy('views', 'DESC')->take(10)->get();
        // dd($moviesPopular);

        $moviesNew = Movie::with('categories')->where(['status' => 'Public'])->orderBy('created_at', 'DESC')->take(10)->get();
        $moviesHotInYear = Movie::with('categories')
            ->where([
                'status' => 'Public',
                'release_year' => Carbon::now()->year
            ])
            ->orderBy('views', 'DESC')
            ->take(10)
            ->get();
        $favorites = Favorite::all();
        if (Auth::check() && isset(Auth::user()->id)) {
            $favoriteMovies = Movie::join('favorites', 'movies.id', '=', 'favorites.movie_id')
                ->where('favorites.user_id', Auth::user()->id)
                ->select('movies.*', 'favorites.created_at as favorited_at')
                ->orderBy('favorites.created_at', 'DESC')
                ->get();
        } else {
            $favoriteMovies = '';
        }


        return view('client_movie.home', compact('moviesPopular', 'favorites', 'favoriteMovies', 'moviesNew', 'moviesHotInYear'));
    }

    // // giao dien moi
    // public function home(Request $request)
    // {
    //     $moviesPopular = Movie::with(['categories', 'episodes'])->where(['status' => 'Public'])->orderBy('views', 'DESC')->take(10)->get();
    //     // dd($moviesPopular);

    //     $moviesNew = Movie::with('categories')->where(['status' => 'Public'])->orderBy('created_at', 'DESC')->take(10)->get();
    //     $trendingMovie = Movie::with('categories')->where(['status' => 'Public'])->orderBy('created_at', 'DESC')->take(10)->get();
    //     $moviesHotInYear = Movie::with('categories')
    //         ->where([
    //             'status' => 'Public',
    //             'release_year' => Carbon::now()->year
    //         ])
    //         ->orderBy('views', 'DESC')
    //         ->take(10)
    //         ->get();
    //     $favorites = Favorite::all();
    //     if (Auth::check() && isset(Auth::user()->id)) {
    //         $favoriteMovies = Movie::join('favorites', 'movies.id', '=', 'favorites.movie_id')
    //             ->where('favorites.user_id', Auth::user()->id)
    //             ->select('movies.*', 'favorites.created_at as favorited_at')
    //             ->orderBy('favorites.created_at', 'DESC')
    //             ->get();
    //     } else {
    //         $favoriteMovies = '';
    //     }


    //     return view('client_movie.home', compact('moviesPopular','trendingMovie', 'favorites', 'favoriteMovies', 'moviesNew', 'moviesHotInYear'));
    // }
}
