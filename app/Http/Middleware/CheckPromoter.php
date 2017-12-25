<?php

namespace App\Http\Middleware;

use Closure;

class CheckPromoter
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
        if (auth()->check() && !auth()->user()->checkPromoter()) {
            return redirect('/user');
        }

        return $next($request);
    }
}
