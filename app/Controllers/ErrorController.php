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
}
