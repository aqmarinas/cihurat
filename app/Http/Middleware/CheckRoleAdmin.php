<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah pengguna sudah login dan memiliki role yang diizinkan
        // if (auth()->check() && auth()->user()->role == $role) {
        //     return $next($request);
        // }

        $guard = Auth::getDefaultDriver();
            dd(Auth::user(), Auth::guard($guard)->check(), $guard);


        if ($guard === 'admin' && Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->role === $role) {
                return $next($request);
            }
        } elseif ($guard === 'users' && Auth::guard('users')->check()) {
            if (Auth::guard('users')->user()->role === $role) {
                return $next($request);
            }
        }

        // Jika tidak sesuai dengan role, redirect atau tampilkan pesan error
        return redirect()->route('dashboard')->withErrors(['access' => 'You do not have access to this feature.']);
    }
}
