<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        Log::info('register-user hit', ['ip' => $request->ip()]);
        // Validate the incoming request data
    try {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email',
            'username'    => 'required|string|max:255|unique:users,username',
            'password'    => 'required|string|min:8|confirmed', // needs password_confirmation
        ]);
    } catch (ValidationException $e) {
        Log::warning('validation failed', ['errors' => $e->errors()]);
        // Let Laravel send 422 JSON errors back
        throw $e;
    }
Log::info('validation passed', ['email' => $validated['email']]);

        try {
            // Create the user
            $user = User::create([
                'first_name'    => $validated['first_name'],
                'middle_name'   => $validated['middle_name'] ?? null,
                'last_name'     => $validated['last_name'],
                'barangay' => $validated['barangay'],
                'email'         => $validated['email'],
                'username'      => $validated['username'],
                'password'      => Hash::make($validated['password']),
            ]);
   Log::info('user created', ['id' => $user->id]);
          } catch (\Throwable $e) {
            Log::error('User create failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // Return response
        return response()->json([
            'message' => 'User created successfully',
            'data'    => $user
        ], 201);
    }
}
