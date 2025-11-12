<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $movie = Movie::where('slug', $request->movie_id)
            ->orWhere('id', $request->movie_id)
            ->firstOrFail();

        if (!$movie) {
            return response()->json(['status' => 'error', 'message' => 'Movie not found'], 404);
        }

        $favorite = Favorite::where([
            'user_id' => $request->user_id,
            'movie_id' => $movie->id
        ])->first();

        if ($favorite) {
            $favorite->delete();
            $action = 'removed';
        } else {
            Favorite::create([
                'user_id' => $request->user_id,
                'movie_id' => $movie->id
            ]);
            $action = 'added';
        }

        // Lấy danh sách yêu thích mới nhất
        $favoriteMovies = Favorite::where('user_id', $request->user_id)
            ->with('movie.categories') // Eager load movie và categories
            ->get()
            ->pluck('movie');

        return response()->json([

            'data' => [
                'status' => "good",
            'action' => $action,

            ],
            'favoriteMovies' => $favoriteMovies
        ]);
    }
}
