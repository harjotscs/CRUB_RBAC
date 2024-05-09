<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);


            $user = null;
            if (!empty($request->email)) {
                $user = User::where('email', $request->email)
                    ->first();

                if (!$user || !password_verify($request->password, $user->password)) {
                    $user = null;
                }
            }

            if ($user) {
                $key = env('JWT_SECRET');
                $payload = [
                    'role_id' => $user->role_id,
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'iat' => time(),
                    'exp' => time() + 60 * 60 * 24 // expiration time (24 hour from now)

                ];
                $token = JWT::encode($payload, $key, 'HS256');

                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'token' => $token
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
