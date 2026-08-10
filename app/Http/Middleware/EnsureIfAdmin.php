<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureIfAdmin {

    public function handle($request, Closure $next) {
         
        if(!Auth::user()->hasRole('Admin')){

            abort(403);

        }

        return $next($request);
    }

}