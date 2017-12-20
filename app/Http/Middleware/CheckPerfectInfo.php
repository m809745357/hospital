<?php

namespace App\Http\Middleware;

use Closure;

class CheckPerfectInfo
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
        if (auth()->check() && auth()->user()->checkPrefect()) {
            return redirect('/user/bind');
        }

        return $next($request);
    }
}
