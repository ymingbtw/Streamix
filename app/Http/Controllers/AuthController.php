<?php

namespace App\Http\Controllers;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $token = $request->bearerToken(); // gets token from Authorization header

        if (!$token) {
            return response()->json([
                'message' => 'Token not provided',
                'isAuthenticated' => false,
            ]);
        }

        try {
            $secretKey = env('JWT_SECRET'); // your secret key

            // Decode the token
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            // $decoded is an object with the JWT payload
            // You can check user info, expiration, etc. here
            $blacklisted = DB::table('blacklisted_tokens')
                ->where('token', $token)
                ->exists();
            if ($blacklisted) {
                return response()->json([
                    'message' => 'token is invalid',
                    'isAuthenticated' => false,
                    'token' => null,
                ]);
            }
            return response()->json(
                [
                    'message' => 'you are authenticated',
                    'isAuthenticated' => true,
                    'role' => $decoded->role,
                    'token' => $token,
                ],
                200
            );
        } catch (ExpiredException $e) {
            return response()->json([
                'message' => 'Token expired',
                'isAuthenticated' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Token invalid: ' . $e->getMessage(),
                'isAuthenticated' => false,
            ]);
        }
    }
}
