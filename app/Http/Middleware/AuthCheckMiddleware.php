<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if JWT authentication is required based on .env setting
        if (env('JWT_AUTH_ENABLED', false)) {
            // If enabled, perform authentication
            if (!Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            // Optionally simulate authentication (for example, for testing or mock requests)
            Auth::shouldUse('api');
        }

        return $next($request);
    }
}
