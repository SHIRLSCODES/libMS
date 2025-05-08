<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLibraryCard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user){
            return redirect()->route('login');
        }
        $card = $user->libraryCard;
        if(!$card){
            return redirect()->route('library-card.subscribe')->with('error', 'You need to subscribe for a library card to borrow books');
        }
        if(!$card->isActive()){
            return redirect()->route('library-card.renew')->with('error', 'Your library card has expired. Please renew.');
        }

        return $next($request);
    }
}
