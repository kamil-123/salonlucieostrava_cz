<?php

namespace App\Http\Middleware;

use Closure;

class StylistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->role == 1 || auth()->user()->role == 2)
        {
            // return new Response(view('unauthorized')->with('role', 'STYLIST'));
            // return 'You are not stylist ';
            return $next($request);
        }
        return redirect('home')->with('error','You have not admin access');
    }
}
