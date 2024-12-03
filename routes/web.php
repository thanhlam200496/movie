<?php

use App\Http\Controllers\admins\CategoryController;
use App\Http\Controllers\admins\DashboardController;
use App\Http\Controllers\admins\EpisodeController;
use App\Http\Controllers\admins\MovieController;
use App\Http\Controllers\clients\CategoryController as ClientsCategoryController;
use App\Http\Controllers\clients\FavoriteController;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\clients\MovieController as ClientsMovieController;
use App\Http\Controllers\clients\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ViewHistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
    Route::get('/', [ClientsCategoryController::class, 'index'])->name('index');
    Route::get('filter', [ClientsCategoryController::class, 'index'])->name('filter');
});
Route::group(['prefix' => 'favorite', 'as' => 'favorite.'], function () {
    Route::post('add', [FavoriteController::class, 'store'])->name('add');
});
Route::group(['prefix' => 'movie', 'as' => 'movie.'], function () {
    Route::get('show/{movie_id}/{episode?}', [ClientsMovieController::class, 'show'])->name('show');
});


Route::controller(GoogleController::class)->group(function () {

    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');

    Route::get('auth/google/callback', 'handleGoogleCallback');
});
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::controller(UserController::class)->group(function () {
    Route::get('signin-form', 'signinForm')->name('signinForm');
    Route::post('signin', 'signin')->name('signin');
    Route::get('signup-form', 'signupForm')->name('signupForm');
    Route::post('signup', 'signup')->name('signup');
});
// routes/web.php
Route::get('/movies/paginate', [MovieController::class, 'paginate'])->name('movies.paginate');

Route::group(
    ['prefix' => 'admin', 'as' => 'admin.'],
    function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::resource('category', CategoryController::class);
        Route::resource('episode', EpisodeController::class);

        Route::get('list-episode/{id}', [EpisodeController::class, 'index'])->name('episode.index');
        Route::get('create-episode/{id}', [EpisodeController::class, 'create'])->name('episode.create');
        Route::get('show-episode/{movie_id}/{episode_id}', [EpisodeController::class, 'show'])->name('episode.show');
        Route::put('update-episode/{movie_id}/{episode_id}', [EpisodeController::class, 'update'])->name('episode.update');
        Route::post('create-episode/{id}', [EpisodeController::class, 'store'])->name('episode.store');
        Route::resource('movie', MovieController::class);
        Route::put('update-status/{id}', [MovieController::class, 'update_status'])->name('update_status');
        // Route::controller('movie',MovieController::class)->group(function ()  {
        //     Route::put('update-status/{id}','update_status')->name('update_status');
        // });
    }
);
// Route::post('/api/view-history', [ViewHistoryController::class, 'store']);
