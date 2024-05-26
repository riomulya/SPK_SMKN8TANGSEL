<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session('isLoggedIn')) {
            if ($request->uri->getPath() !== '/') {
                // If not logged in and not accessing home page, redirect to login page
                return redirect()->to('/');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah request
    }
}
