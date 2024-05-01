<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect()->intended(route('blog.index'))->with('success', 'Heureux de vous revoir ' . Auth::user()->name . '!');
        }

        return to_route('auth.login')->withErrors([
            'email' => 'Identifiants invalides'
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login')->with('success', 'Vous avez bien été déconnecté');
    }
}
