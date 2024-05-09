<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\Key;
use App\Models\User;

class HasAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        try {
            $token = $request->bearerToken();

            if ($token) {
                $key = env('JWT_SECRET');

                $decryptedToken = JWT::decode($request->bearerToken(), new Key($key, 'HS256'));

                $roleId = $decryptedToken->role_id;
                $email = $decryptedToken->email;

                $user = User::where('email', $email)->first();
                if (!$user || !$user->role_id) {
                    return response()->json(['message' => 'Unauthorized, User doesn\'t exist.'], Response::HTTP_FORBIDDEN);
                }
                $request->merge(['user' => $user]);
                $role = Role::where('id', $roleId)->first();
                if (!$role) {
                    return response()->json(['message' => 'Unauthorized, Role doesn\'t exist.'], Response::HTTP_FORBIDDEN);
                }

                // Check if the user has the specified permission
                if ($role->hasPermissionTo($permission)) {
                    // If user has permission, proceed with the request
                    return $next($request);
                } else {
                    // If user does not have permission, return an error response
                    return response()->json(['error' => 'Unauthorized. User does not have permission.'], 403);
                }
            } else {
                return response()->json(['error' => 'Unauthorized. Token not provided.'], 401);
            }
        } catch (\Exception $e) {
            // Other JWT decoding errors
            return response()->json(['success' => false, 'error' => 'Invalid token'], 400);
        }

    }
}
