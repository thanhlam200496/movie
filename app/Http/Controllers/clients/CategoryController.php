<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index()  {
        $movies=Movie::where('status','Public')->get();
        return view('client_movie.category',compact('movies'));
    }
}
