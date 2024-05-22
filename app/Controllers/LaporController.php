<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\UserModel;

class LaporController extends BaseController
{
    protected $guruModel;
    protected $userModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->userModel = new UserModel();
    }

    public function index(): string
    {
        $guru = $this->guruModel->findAll();

        $data = [
            'title' => 'Settings Data Guru',
            'guru' => $guru
        ];

        return view('pages/pelaporan/lapor_siswa', $data);
    }
}
