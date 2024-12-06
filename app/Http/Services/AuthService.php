<?php

namespace App\Http\Services;

use App\Models\User;

class AuthService
{
    public $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function showFormLogin()
    {
        return view('auth.login');
    }

    public function login($request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return redirect()->back()->with('error', 'Login failed');
    }

    public function showFormRegister()
    {
        return view('auth.register');
    }

    public function register($request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return redirect()->intended('/home');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function showFormResetPW()
    {
        return view('auth.forgot-password');
    }
}
