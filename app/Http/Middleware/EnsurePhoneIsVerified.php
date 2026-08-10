<?php

namespace App\Http\Middleware;
use Closure;

class EnsurePhoneIsVerified {

    public function handle($request, Closure $next) {
         
        if(empty(auth()->user()->phone_verified_at)){

            return redirect()->route('account.verification');

        }

        return $next($request);
    }

}