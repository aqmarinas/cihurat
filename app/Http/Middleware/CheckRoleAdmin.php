<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if (auth()->check() && auth()->user()->role == $role) {
            return $next($request);
        }

        // Jika tidak sesuai dengan role, redirect atau tampilkan pesan error
        return redirect()->route('admin.dashboard')->withErrors(['access' => 'You do not have access to this feature.']);
    }
}
