<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => "Dashboard Penilaian Karakter"
        ];
        if (session('isLoggedIn') && session('role') !== 'siswa') {
            return view('/pages/dashboard/dashboard_admin', $data);
        } else {
            return view('/pages/dashboard/dashboard_siswa', $data);
        }
    }
}
