<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthentificationController extends Controller
{
    public function register(Request $request)
    {



        $request->validate([
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|email|unique:users|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'password' => 'required|string|min:6|max:12',
            'phone' => 'required|string|min:10|max:15',
        ],
        [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name must not exceed 40 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'email.regex' => 'Email must be a Gmail address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.max' => 'Password must not exceed 12 characters',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

            public function getLoginPage()
        {
            return view('Authenticate/login');
        }

        public function getRegisterPage()
        {
            return view('Authenticate/register');
        }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'password.required' => 'Password is required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = null;

            return response()->json(['message' => 'Login successful', 'token' => $token, 'user' => $user], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}