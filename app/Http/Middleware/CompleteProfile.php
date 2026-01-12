<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompleteProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function hasIncompleteProfile($user)
    {
        
        if (empty($user->name) || empty($user->email) || empty($user->username) || empty($user->description)) {
            return true;
        }
    
        return false;
    }

    public function handle(Request $request, Closure $next): Response
    {
        
        if (auth()->check() && $this->hasIncompleteProfile(auth()->user())) {
            $notification = array(
                'message' => 'You cannot continue without completing your profile information.',
                'alert-type' => 'warning',
            );
            return redirect()->route('user.profile')->with($notification);
        }
        return $next($request);
    }
}
