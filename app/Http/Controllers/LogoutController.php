<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $token = $request->bearerToken();

            Log::info('Token: ' . $token);

            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 400);
            }

            // Log step before invalidation
            Log::info('Attempting to invalidate token');

            auth()->setToken($token)->invalidate();

            // Log step after invalidation
            Log::info('Token invalidated successfully');

            return response()->json(['message' => 'User successfully signed out'], 200);
        } catch (JWTException $e) {
            Log::error('Logout Error: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to sign out, please try again.'], 500);
        }
    }
}
