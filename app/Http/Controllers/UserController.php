<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Validation;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $nameResult = Validation::validateName($name);
        $emailResult = Validation::validateEmail($email);
        $passwordResult = Validation::validatePassword($password);
        if (!$nameResult['valid']) {
            return response()->json([
                'success' => false,
                'type' => 'name',
                'payload' => [
                    'valid' => false,
                    'error' => $nameResult['error'],
                    'value' => $name,
                ],
            ]);
        }

        if (!$emailResult['valid']) {
            return response()->json([
                'success' => false,
                'type' => 'email',
                'payload' => [
                    'valid' => false,
                    'error' => $emailResult['error'],
                    'value' => $email,
                ],
            ]);
        }
        if (!$passwordResult['valid']) {
            return response()->json([
                'success' => false,
                'type' => 'password',
                'payload' => [
                    'valid' => false,
                    'error' => $passwordResult['error'],
                    'value' => $password,
                ],
            ]);
        }
        $user = User::where('email', '=', $email)->first();
        if ($user) {
            return response()->json([
                'success' => false,
                'type' => 'email',
                'payload' => [
                    'valid' => false,
                    'error' => 'email exists',
                    'value' => $email,
                ],
            ]);
        }
        $role = \App\Models\Role::where('name', 'user')->first();
        if ($role) {
            $user = User::create([
                'id' => Str::uuid(),
                'name' => $nameResult['value'],
                'email' => $emailResult['value'],
                'password' => Hash::make($passwordResult['value']),
            ]);
            $user->roles()->attach($role->id);
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'cant register at the moment',
            ]);
        }
    }

    public function signin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $emailResult = Validation::validateEmail($email);
        $passwordResult = Validation::validatePassword($password);
        if (!$emailResult['valid']) {
            return response()->json([
                'success' => false,
                'type' => 'email',
                'payload' => [
                    'valid' => false,
                    'error' => $emailResult['error'],
                    'value' => $email,
                ],
            ]);
        }
        if (!$passwordResult['valid']) {
            return response()->json([
                'success' => false,
                'type' => 'password',
                'payload' => [
                    'valid' => false,
                    'error' => $passwordResult['error'],
                    'value' => $password,
                ],
            ]);
        }

        $user = User::where('email', $email)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->with('roles')
            ->first();

        if (!$user) {
            $user = User::where('email', $email)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'user');
                })
                ->with('roles')
                ->first();
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'type' => 'email',
                'payload' => [
                    'valid' => false,
                    'error' => 'There is no user asscociated with email ',
                    'value' => $email,
                ],
            ]);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'type' => 'password',
                'payload' => [
                    'valid' => false,
                    'error' => 'Incorrect password',
                    'value' => $password,
                ],
            ]);
        }

        $payload = [
            'role' => $user->roles->first()->name,
            'iss' => 'streamix', // Issuer
            'sub' => $user->id, // Subject (user id)
            'iat' => time(), // Issued at
            'exp' => time() + 60 * 60 * 24, // Expiration (1 day)
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        $cookie = cookie(
            'auth_token', // name
            $jwt, // value
            0, // minutes
            '/', // path
            '.ecnet.space', // domain (null = current)
            true, // secure: true in production with HTTPS
            false, // httpOnly
            false, // raw (leave false)
            'None' // SameSite: 'Lax', 'Strict', or 'None'
        );

        return response()
            ->json([
                'success' => true,
                'token' => $jwt,
            ])
            ->cookie($cookie);
    }
    public function signout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'Token not provided',
                'success' => false,
            ]);
        }

        try {
            $secretKey = env('JWT_SECRET');

            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            DB::table('blacklisted_tokens')->insert([
                'token' => $token,
                'expires_at' => $decoded->exp,
            ]);

            return response()
                ->json([
                    'message' => 'you are signed out',
                    'success' => true,
                    'status' => 200,
                    'isAuthorized' => true,
                ])
                ->withoutCookie('auth_token', '/');
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Token expired',
                'success' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Token invalid: ' . $e->getMessage(),
                'success' => false,
            ]);
        }
    }
    public function profile() {}
}
