<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function index(): string
    {
        
         return view('partials/header')
         .view('auth/login')
         .view('partials/footer');
         
    }
    public function login(): string
    {
     
        
    }
}
