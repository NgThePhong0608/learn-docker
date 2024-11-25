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
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->intended('/hello');
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
        ]);

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        auth()->login($user);

        return redirect()->intended('/hello');
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
