<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlayerSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('token')) {
            return redirect('/login')->withErrors(['You must be logged in.']);
        }
        return $next($request);
    }
}
