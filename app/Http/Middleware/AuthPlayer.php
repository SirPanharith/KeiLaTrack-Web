<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthPlayer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $playerInfoId = session('playerToken');

    // Check if PlayerInfoId is retrieved correctly from session
    if (!$playerInfoId) {
        \Log::error('PlayerInfoId not found in session');
        return redirect()->route('login.show')->withErrors(['message' => 'Session expired or invalid. Please log in again.']);
    }
        return $next($request);
    }
}
