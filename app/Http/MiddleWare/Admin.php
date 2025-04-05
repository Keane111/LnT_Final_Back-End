<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}