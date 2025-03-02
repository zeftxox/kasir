<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLevel
{
    public function handle(Request $request, Closure $next, $level)
    {
        if (Auth::check() && Auth::user()->user_level === $level) {
            return $next($request);
        }
        return redirect('/dashboard')->with('error', 'Akses tidak diizinkan!');
    }
}
