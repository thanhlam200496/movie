<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Movie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
public function index(Request $request)
{
    $moviesFilter = Movie::query()->with('categories');

    if ($request->filled('search')) {
        $moviesFilter->where('title', 'like', '%' . $request->search . '%');
    }
    if ($request->filled('type_film')) {
        $moviesFilter->where('type_film', 'like', '%' . $request->type_film . '%');
    }
    if ($request->filled('category')) {
        $categoryId = $request->input('category');
        $moviesFilter->whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        });
    }
    if ($request->filled('years')) {
        // Giả sử release_year là số hoặc string — điều chỉnh theo DB
        $moviesFilter->where('release_year', $request->years);
    }

    $categories = Category::orderBy('name', 'ASC')->get();

    $movies = $moviesFilter->where('status', 'Public')
        ->orderBy('created_at', 'DESC')
        ->paginate(12)
        ->withQueryString(); // giữ query string trong links()

    $favorites = Favorite::all();

    // Nếu request AJAX (fetch từ JS), trả JSON gồm html partial và pagination partial
    if ($request->ajax()) {
        $html = view('client_movie.partials.movie_list', compact('movies'))->render();
        $pagination = view('client_movie.partials.pagination', compact('movies'))->render();

        // count text giống .post-result
        $from = $movies->firstItem();
        $to = $movies->lastItem();
        $total = $movies->total();
        $countText = ($from && $to)
            ? "Showing $from to $to item of $total results"
            : "Showing 0 results";

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'countText' => $countText,
        ]);
    }

    return view('client_movie.category', compact('movies', 'favorites', 'categories'));
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

    $movies = $query->orderBy('created_at','desc')->paginate(12);

    $html = view('client_movie.partials.movie_list', compact('movies'))->render();
    $pagination = view('client_movie.partials.pagination', compact('movies'))->render();

    return response()->json(['html' => $html, 'pagination' => $pagination]);
}

}
