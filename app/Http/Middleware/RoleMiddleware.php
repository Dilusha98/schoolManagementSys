<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            abort(403);
        }

        // $user = Auth::user();
        // dd($user->role);
        // if (!in_array($user->role, $roles)) {
        //     abort(403); // Unauthorized
        // }

        return $next($request);
    }
}
