<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => "Dashboard Penilaian Karakter"
        ];
        return view('/pages/dashboard/dashboard_admin', $data);
    }
}
