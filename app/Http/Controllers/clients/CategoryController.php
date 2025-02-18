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
        return view('client_movie.category', compact('movies', 'favorites','categories'));
    }


public function fetchMovies(Request $request)
{
    $page = $request->get('page', 1); // Lấy số trang hiện tại từ request
    $perPage = 12; // Số lượng phim trên mỗi trang
    $favorites=Favorite::all();
    
    // Lấy danh sách danh mục (categories)
    $categories = Category::orderBy('name', 'ASC')->get();
    // Lấy danh sách phim theo phân trang
    $movies = Movie::query()->paginate($perPage, ['*'], 'page', $page);

    return response()->json([
        'movies' => $movies->items(),
        // 'favorites' => $favorites->items(),
        // 'categories' => $categories->items(),
        'nextPage' => $movies->currentPage() < $movies->lastPage() ? $movies->currentPage() + 1 : null,
    ]);
}

}
