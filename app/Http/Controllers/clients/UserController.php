<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Movie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }
    public function signinForm()
    {
        return view('client_movie.signin');
    }
    public function signupForm()
    {
        return view('client_movie.signup');
    }
public function signinAjax(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        return response()->json([
            'success' => true,
            'data' => [
                'code' => '1',
                'message' => 'Đăng nhập thành công!',
                'redirect' => url('/'),
                'data'=>$credentials
            ]
        ]);
    }

    return response()->json([
        'success' => false,
        'data' => [
            'code' => '0',
            'message' => 'Tài khoản hoặc mật khẩu không đúng.',
            'data'=>$credentials
        ]
    ]);
}

    public function signin(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data, $request->remember)) {
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
    }
    public function signup(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'name' => 'required',
                'password' => 'required'
            ]
        );
        $data = $request->only('email', 'password', 'name');
        $data['password'] = Hash::make($request->password);
        user::create($data);
        return redirect()->route('home');
    }

    // public function login(Request $request)
    // {
    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json(['message' => 'Đăng nhập thất bại'], 401);
    //     }

    //     $user = Auth::user();
    //     $token = $user->createToken('auth-token')->plainTextToken;

    //     return response()->json(['user' => $user, 'token' => $token]);
    // }

    public function personal() {
        $moviesPopular = Movie::with(['categories', 'episodes'])->where(['status' => 'Public'])->orderBy('views', 'DESC')->take(10)->get();
        // dd($moviesPopular);

        $moviesNew = Movie::with('categories')->where(['status' => 'Public'])->orderBy('created_at', 'DESC')->take(10)->get();
        $moviesHotInYear = Movie::with('categories')
            ->where([
                'status' => 'Public',
                'release_year' => Carbon::now()->year
            ])
            ->orderBy('views', 'DESC')
            ->take(10)
            ->get();
        $favorites = Favorite::all();
        if (Auth::check() && isset(Auth::user()->id)) {
            $favoriteMovies = Movie::join('favorites', 'movies.id', '=', 'favorites.movie_id')
                ->where('favorites.user_id', Auth::user()->id)
                ->select('movies.*', 'favorites.created_at as favorited_at')
                ->orderBy('favorites.created_at', 'DESC')
                ->get();
        } else {
            $favoriteMovies = '';
        }
        $moviesPopular = Movie::with(['categories', 'episodes'])->where(['status' => 'Public'])->orderBy('views', 'DESC')->take(10)->get();
        return view('client_movie.personal',compact('moviesPopular', 'favorites', 'favoriteMovies', 'moviesNew', 'moviesHotInYear'));
    }
}
