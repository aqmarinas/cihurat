<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan. Untuk informasi lebih lanjut, silakan hubungi admin.');
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // check if this is the first authentication check in the session
            if (!session()->has('auth_checked')) {
                session(['auth_checked' => true]); // mark as first-time check
                return route('login');
            }
            Session::flash('error', 'Sesi habis. Anda harus masuk terlebih dahulu!');
            return route('login');
        }
        return null;
    }
}
