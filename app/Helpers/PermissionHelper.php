<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function hasPermission($permission)
    {
        if (Auth::check()) {
            return Auth::user()->hasPermissionTo($permission);
        }

        return false;
    }

    public static function hasRole($role)
    {
        if (Auth::check()) {
            return Auth::user()->hasRole($role);
        }

        return false;
    }
}
