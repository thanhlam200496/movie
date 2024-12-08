<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\LeechMovieUrl;
use Illuminate\Http\Request;

class LeechMovieUrlCOntroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leechUrls=LeechMovieUrl::paginate(5);
        return view('admin_movie.leech_movie_urls.index',compact('leechUrls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_movie.leech_movie_urls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //    try {
        LeechMovieUrl::create($request->only('url_detail','url_poster','slug','url_video_m3u8','name','url_list_movie'));
        return redirect()->route('admin.leech_url.index')->with('success','Thêm mới thành công');
    //    } catch (\Throwable $th) {
    //     //throw $th;
    //    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
