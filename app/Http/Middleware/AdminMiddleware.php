<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan memiliki peran admin
        if (Auth::check() && Auth::user() === 'admin'()) {
            return $next($request);
        }

        // Redirect ke halaman utama jika bukan admin
        return redirect('/');
    }
}
