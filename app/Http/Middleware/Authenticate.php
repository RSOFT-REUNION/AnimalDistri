<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $route = request()->route()->getName();
        if(str_contains($route, 'backend') ) {
            return $request->expectsJson() ? null : route('backend.login');
        } else {
            return $request->expectsJson() ? null : route('login');
        }
    }
}
