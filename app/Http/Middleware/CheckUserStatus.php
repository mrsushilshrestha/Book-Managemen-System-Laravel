<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (auth()->check() && auth()->user()->status === 'inactive') {
        auth()->logout();

        return redirect()->route('login')->withErrors([
            'inactive' => 'Your account is inactive. Please contact admin.'
        ]);
        }
        return $next($request);
    }
}
