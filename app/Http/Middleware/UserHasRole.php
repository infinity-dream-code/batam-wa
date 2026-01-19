<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserHasRole
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
