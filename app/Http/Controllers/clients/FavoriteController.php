<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $favorite = Favorite::where([
            'user_id' => $request->user_id,
            'movie_id' => $request->movie_id
        ])->first();

        if ($favorite) {
            $favorite->delete();
            $action = 'removed';
        } else {
            Favorite::create([
                'user_id' => $request->user_id,
                'movie_id' => $request->movie_id
            ]);
            $action = 'added';
        }

        // Lấy danh sách yêu thích mới nhất
        $favoriteMovies = Favorite::where('user_id', $request->user_id)
            ->with('movie.categories') // Eager load movie và categories
            ->get()
            ->pluck('movie');

        return response()->json([
            'success' => true,
            'action' => $action,
            'favoriteMovies' => $favoriteMovies
        ]);
    }
}       
