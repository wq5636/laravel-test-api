<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request) : JsonResponse {
        try {
            $customMessages = [
                'email.unique' => 'The email address is already in use.',
                'password.regex' => 'The password must be at least 10 characters long and contain at least one uppercase letter, lowercase letter, and digit.',
            ];

            $attributes = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:contacts',
                'password' => ['required', 'string', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{10,}$/'],
            ], $customMessages);

            $user = User::create([
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => bcrypt($attributes['password']),
            ]);

            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'name' => $user->name,
                'token' => $token,
            ], 201);

        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return response()->json(['errors' => $errors], 422); // 422 Unprocessable Entity
        }
    }


    public function login(Request $request) : JsonResponse {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('api_token')->plainTextToken;
            return response()->json([
                'name' => $user->name,
                'token' => $token,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }


    public function logout() : JsonResponse {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
