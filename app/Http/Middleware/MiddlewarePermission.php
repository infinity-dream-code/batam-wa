<?php

namespace App\Http\Middleware;

use App\Helpers\Constant;
use App\Helpers\RoutePermission;
use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class MiddlewarePermission
{
    public function handle($request, Closure $next)
    {
        // dd($request->route()->getName());
        $userRoute = array_slice(explode(".", $request->route()->getName()), -2);

        $userRole = Auth::user()->roles->toArray();
        
        $idRole = $userRole[0]['id'];
        $permissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
            ->where('role_has_permissions.role_id', $idRole)
            ->pluck('name')
            ->toArray();

        $routePermission = (new RoutePermission())->permissionRole($permissions);
        if (in_array('super-admin', Auth::user()->roles->pluck('name')->toArray())) {
            return $next($request);
        }
        if (!in_array("" . $userRoute[0] . "." . $userRoute[1], $routePermission)) {
            abort(401);
        }

        return $next($request);
    }
}
