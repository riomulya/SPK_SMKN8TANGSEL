<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ErrorController extends Controller
{
    public function unauthorized()
    {
        $data = [
            'title' => 'Unauthorized Access',
        ];

        return view('pages/error/unauthorized', $data);
    }

    public function show404()
    {
        // Set header HTTP status code 404
        $this->response->setStatusCode(404);
        $data = [
            'title' => 'Page Not Found',
        ];
        // Load view khusus untuk halaman 404
        echo view('pages/error/not_found', $data);
    }
}
