<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CapitalizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $excludeFields = ['email', 'password', 'password_confirmation'];
        $data = $request->all();

        // capitalize each word
        foreach ($data as $key => $value) {
            if (is_string($value) && !in_array($key, $excludeFields)) {
                $data[$key] = ucwords(strtolower($value));
            }
        }

        $request->merge($data);

        return $next($request);
    }
}
