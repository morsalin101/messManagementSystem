<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('admin/partials/header')
        .view('admin/partials/top')
        .view('admin/partials/sidebar')
         .view('admin/index')
         .view('admin/partials/footer');
    }
}
