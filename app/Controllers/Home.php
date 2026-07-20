<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function operateur()
    {
        return view('auth/login-operateur');
    }

    public function client()
    {
        return view('auth/login-client');
    }
}
