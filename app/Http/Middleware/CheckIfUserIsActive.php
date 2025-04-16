<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class CheckIfUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() && !Auth::user()->is_active)
        {
            Auth::logout();

            return redirect()->route('login')->with('error', 'You have been deactivated, please contact the admin'); 
        }

        return $next($request);
    }
}
