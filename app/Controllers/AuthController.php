<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function login(): string
    {
        return view('auth/login');
    }

    public function register(): string
    {
        return view('auth/register');
    }
}
