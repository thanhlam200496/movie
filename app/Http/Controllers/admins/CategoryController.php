<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $query = Category::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        $categories = $query->paginate(10);

        return view('admin_movie.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin_movie/categories/create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'max:255|required',
            'description' => 'max:255|required',
        ]);
        Category::create($request->all('name', 'description'));
        return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục thành công');
    }
    public function show(Category $category)
    {
        return view('admin_movie.categories.show', compact('category'));
    }
    public function destroy(Category $category)
    {
        $message='Danh mục '.$category->name.' được xóa thành công';
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', $message);
    }
    public function update(Category $category, Request $request) {
        $request->validate([
            'name' => 'max:255|required',
            'description' => 'max:255|required',
        ]);
        $category->update($request->all('name', 'description'));
        return redirect()->route('admin.category.index')->with('success', 'Sửa danh mục thành công');
    }
}
