<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\User;
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
}
