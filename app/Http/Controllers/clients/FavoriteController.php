<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
   function store(Request $request) {
    $favorite= Favorite::where(['user_id'=>$request->user_id,'movie_id'=>$request->movie_id])->first();
    if (isset($favorite->id)) {
      Favorite::where(['user_id'=>$request->user_id,'movie_id'=>$request->movie_id])->delete();
    }else{
          Favorite::create(['user_id'=>$request->user_id,'movie_id'=>$request->movie_id]);
    }
    
    // dd($favorite);
    return redirect()->back();
   }
}
