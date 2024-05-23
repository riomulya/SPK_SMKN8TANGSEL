<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\UserModel;

class LaporController extends BaseController
{
    protected $siswaModel;
    protected $userModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
    }

    public function index(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Settings Data Siswa',
            'siswa' => $siswa
        ];

        return view('pages/pelaporan/lapor_siswa', $data);
    }
}
