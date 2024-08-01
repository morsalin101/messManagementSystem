<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        
        
         return view('partials/header')
        .view('partials/top')
        .view('partials/sidebar')
         .view('index')
         .view('partials/footer');
    }
    public function login(): string
    {
        return view('partials/header')
        .view('auth/login')
        .view('partials/footer');
        
    }
}
