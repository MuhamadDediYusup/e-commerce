<?php

namespace App\Http\Middleware;

use Closure;

class User
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
        // if(empty(session('user'))){
        if(!$request->session()->has('user')){
            return redirect()->route('login.form');
        }
        else{
            return $next($request);
        }
    }
}
