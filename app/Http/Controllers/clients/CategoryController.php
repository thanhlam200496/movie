<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Movie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index(Request $request)
    {
        $moviesFilter = Movie::query()->with('categories');

        // Tìm kiếm theo tiêu đề
        if ($request->has('search')&&$request->search!=null) {
            $moviesFilter->where('title', 'like', '%' . $request->search . '%');

        }
        if ($request->has('type_film')&&$request->type_film!=null) {
            $moviesFilter->where('type_film', 'like', '%' . $request->type_film . '%');
        }
        // Tìm kiếm theo danh mục
        if ($request->has('category')&&$request->category!=null) {
            $categoryId = $request->input('category');
            $moviesFilter->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            });
        }

        // Lấy danh sách danh mục (categories)
        $categories = Category::orderBy('name', 'ASC')->get();

        // Lấy danh sách phim (movies)
        $movies = $moviesFilter->where('status', 'Public')
            ->orderBy('created_at', 'DESC')
            ->paginate(30);
            // dd($movies);
        ;
        $favorites=Favorite::all();
        if ($request->ajax()) {
    return response()->view('client_movie.category', compact('movies', 'favorites', 'categories'))->header('Vary', 'X-Requested-With');
}
        return view('client_movie.category', compact('movies', 'favorites','categories'));
    }


public function fetchMovies(Request $request)
{
    $page = $request->get('page', 1);
    $perPage = 12;

    $query = Movie::query()->with('categories')->where('status', 'Public');

    // Giữ lại các bộ lọc như trong index()
    if ($request->has('search') && $request->search != null) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->has('type_film') && $request->type_film != null) {
        $query->where('type_film', 'like', '%' . $request->type_film . '%');
    }

    if ($request->has('category') && $request->category != null) {
        $categoryId = $request->input('category');
        $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    $movies = $query->paginate($perPage, ['*'], 'page', $page);

    return response()->json([
        'movies' => $movies->items(),
        'nextPage' => $movies->currentPage() < $movies->lastPage() ? $movies->currentPage() + 1 : null,
    ]);
}

}
