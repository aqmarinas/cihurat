<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
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
