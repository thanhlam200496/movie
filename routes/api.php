<?php

use App\Http\Controllers\admins\MovieController;
use App\Http\Controllers\clients\CommentController;
use App\Http\Controllers\clients\FavoriteController;
use App\Http\Controllers\clients\UserController;
use App\Http\Controllers\ViewHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/movies/paginate', [MovieController::class, 'paginate']);
// Route::post('/register', [UserController::class, 'register']);
// Route::post('/login', [UserController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/view-history', [ViewHistoryController::class, 'store'])

;

Route::controller(UserController::class)->group(function () {

    Route::post('signinAjax', 'signinAjax')->name('signinAjax');

});
// Route::post('/comments', [CommentController::class, 'store'])->name('comment');
Route::controller(CommentController::class)->group(function () {
    Route::post('add-comment', 'store')->name('comment');
});
Route::group(['prefix' => 'favorite', 'as' => 'favorite.'], function () {
    Route::post('add', [FavoriteController::class, 'store'])->name('add');
});
