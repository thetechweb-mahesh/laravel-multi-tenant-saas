<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'active_company_id' => session('active_company_id'), 
    ]);

    return response()->json(['message' => 'User registered', 'user' => $user], 201);
}



public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = $request->user();

    return response()->json([
        'message' => 'Login successful',
        'token' => $user->createToken('api-token')->plainTextToken,
    ]);
}



public function logout(Request $request)
{
    
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'User successfully logged out']);
}


}
