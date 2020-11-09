<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'register']);
    }

    public function register(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|min:4|max:120',
            'email' => 'required|email|min:5|max:120|unique:users',
            'password' => 'required|min:6|max:50|confirmed'
        ]);
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return Response::json([
            'message' => 'Registration complete, please login.'
        ]);
    }

    public function login(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $user->tokens()->delete();

            return Response::json([
                'message' => 'Logged in successfully!',
                'login_token' => $user->createToken('login', ["*"])->plainTextToken
            ]);
        }

        return Response::json([
            'message' => 'Wrong credentials'
        ], 400);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return Response::json([
            'message' => 'Logged out successfully!'
        ]);
    }
}
