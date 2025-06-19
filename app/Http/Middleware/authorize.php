<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

class authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // gets token from Authorization header

        if (!$token) {
            return response()->json([
                'message' => 'Token not provided',
                'isAuthorized' => false,
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
                    'isAuthorized' => false,
                ]);
            }
            if ($decoded->role == 'user' || $decoded->role == 'admin') {
                return $next($request);
            }
            return response()->json([
                'isAuthorized' => false,
            ]);
        } catch (ExpiredException $e) {
            return response()->json([
                'message' => 'Token expired',
                'isAuthorized' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Token invalid: ' . $e->getMessage(),
                'isAuthorized' => false,
            ]);
        }
    }
}
