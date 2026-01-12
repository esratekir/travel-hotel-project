<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfUserNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('web')->check()) {
            // Kullanıcı giriş yapmamışsa, isteği durdurun ve istediğiniz sayfaya yönlendirin
            return redirect()->route('home'); // Kullanıcı login sayfasına yönlendiriyoruz
        }
    
        // Kullanıcının rolünü kontrol et
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            // Admin rolü için
            // Logu ekrana yazdırabiliriz
            //dd('Admin Rolüne Sahip Kullanıcı: ' . $user->name);
            return redirect()->route('home'); // Admin rolü için ayrı login sayfasına yönlendiriyoruz
        } else {
            // Normal kullanıcı rolü için
            // Logu ekrana yazdırabiliriz
            //dd('Normal Kullanıcı: ' . $user->name);
            return $next($request); // Normal kullanıcı rolü için ayrı login sayfasına yönlendiriyoruz
        }

        
    }
}
