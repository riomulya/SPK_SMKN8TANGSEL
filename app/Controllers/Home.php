<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => "Sistem Penilaian Karakter"
        ];
        return view('welcome_message', $data);
    }
}
