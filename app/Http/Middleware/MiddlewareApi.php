<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class MiddlewareApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');

        $accessToken = User::where('token', $token)
            ->exists();

        if ($accessToken) {
            return $next($request);
        }
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized! Wrong token access'
        ], 401);
    }
}
