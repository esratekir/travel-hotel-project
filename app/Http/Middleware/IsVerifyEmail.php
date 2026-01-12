<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->is_email_verified) {
            $message = "You need to confirm your account. We have sent you an activation code, please check your email.";
            return redirect()->route('home')->with('message', $message);
        }
        return $next($request);
    }
}
