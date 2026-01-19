<?php

namespace App\Http\Middleware;

use App\Helpers\PermissionHelper;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $roleOrPermission)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        try {
            if (PermissionHelper::hasRole('super-admin') ||  Auth::user()->hasPermissionTo($roleOrPermission)) {
                return $next($request);
            }
        } catch (AuthorizationException $exception) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['error' => 'Request Not Found'], 404);
            }
            abort(404, 'Page not found.');
        }

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['error' => 'Request Not Found'], 404);
        }

        abort(404, 'Page not found.');
    }
}
