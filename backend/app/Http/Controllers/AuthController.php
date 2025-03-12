<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request) 
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = $user->role;
            $token = $user->createToken('authToken')->plainTextToken;
            
            return response()->json([
                'token' => $token,
                'user' => $user,
                'role' => $role,  // Trả về role của người dùng
            ]);
        }
        
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function me(Request $request)
    {
        return response()->json(Auth::user()); // Sửa lại ở đây
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // Sửa lại ở đây
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete(); // Xóa token cũ
        $newToken = $user->createToken('authToken')->plainTextToken;
        
        return response()->json(['token' => $newToken]);
    }
}
