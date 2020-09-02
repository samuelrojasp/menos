<?php

namespace App\Http\Middleware;

use Closure;
use Twilio\Rest\Client;

class CheckVerifiedPhone
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
        $user = auth()->user();
        
        if ($user != null) {
            $is_verified = $user->is_verified;

            if ($is_verified == false) {
                return redirect('/verify');
            }
        }

        return $next($request);
    }
}
