<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials) && Auth::user()->isModerator()) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'نام کاربری و یا گذرواژه صحیح نیست',
        ]);
    }

    public function getCredentials()
    {
        return Auth::check()?Auth::user()->only(['id', 'name', 'email', 'type']):'';
    }

    public function checkLogin(Request $request)
    {
        return Auth::check();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    public function logoutAndRedirect(Request $request)
    {
        $this->logout($request);
        return redirect('/');
    }
}
