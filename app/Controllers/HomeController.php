<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => "Sistem Penilaian Karakter"
        ];
        return view('login_page', $data);
    }
}
