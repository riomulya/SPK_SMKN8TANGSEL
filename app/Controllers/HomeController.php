<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => "Sistem Penilaian Karakter"
        ];
        return view('landing_page', $data);
    }
}
