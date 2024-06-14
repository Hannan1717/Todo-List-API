<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
            ]);

            if (Auth::attempt($credentials)) {
                // Jika autentikasi berhasil, buat token atau responkan user

                $token = Auth::user()->createToken('todo-api')->plainTextToken;

                $user = Auth::user();
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'token'  => $token
                ], 200);
            }

            return response()->json([
                'error' => 'Your credentials do not match our records.'
            ], 401);  // Gunakan kode status 401 untuk Unauthorized

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
