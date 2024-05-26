<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends Controller
{
    public function index(): ResponseInterface
    {
        $data = [
            'title' => "Sistem Penilaian Karakter"
        ];

        if (!session('isLoggedIn')) {
            return $this->response->setBody(view('login_page', $data));
        }

        return redirect()->to('/dashboard');
    }
}
