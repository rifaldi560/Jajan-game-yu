<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan memiliki peran user
        if (Auth::check() && Auth::user() === 'user'()) {
            return $next($request);
        }

        // Redirect ke halaman utama jika bukan user
        return redirect('/  ');
    }
}
