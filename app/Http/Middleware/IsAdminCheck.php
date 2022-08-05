<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminCheck
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
        if (Auth::user()->type === 'admin'):
          return $next($request);
        else:
          Auth::logout();
          return redirect()->route('login')->with('error','You Access An Unauthorised Page');
        endif;

    }
}
