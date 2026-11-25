<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $adminEmail = config('app.admin_email');
        $isConfiguredAdmin = is_string($adminEmail)
            && $adminEmail !== ''
            && strcasecmp($credentials['email'], $adminEmail) === 0;

        if ($isConfiguredAdmin && Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('tempats.index'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tempats.index');
    }
}
