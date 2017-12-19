<?php

namespace App\Http\Middleware;

use Closure;

class CheckAddress
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
        if (auth()->user()->checkAddress()) {
            return redirect('/user/room');
        }

        return $next($request);
    }
}
