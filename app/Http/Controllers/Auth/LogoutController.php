<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    /**
     * Handle user logout and redirect to login page.
     *
     * @return RedirectResponse
     */
    public function signout(): RedirectResponse
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login')->with('status', 'Anda berhasil logout.');
    }
}
