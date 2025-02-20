<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // brute force
        $throttleKey = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->with('error', 'Terlalu banyak percobaan masuk. Silakan coba lagi dalam ' . RateLimiter::availableIn($throttleKey) . ' detik.');
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey); // reset
            return redirect()->route('dashboard');
        }

        RateLimiter::hit($throttleKey, 60);
        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
