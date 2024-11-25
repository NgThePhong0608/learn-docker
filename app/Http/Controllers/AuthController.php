<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function showFormLogin()
    {
        return $this->service->showFormLogin();
    }

    public function login(Request $request)
    {
        return $this->service->login($request);
    }

    public function showFormRegister()
    {
        return $this->service->showFormRegister();
    }

    public function register(Request $request)
    {
        return $this->service->register($request);
    }

    public function logout()
    {
        return $this->service->logout();
    }

    public function showFormResetPW()
    {
        return $this->service->showFormResetPW();
    }
}
