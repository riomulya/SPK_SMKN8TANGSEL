<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Penilaian extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Setting Penilaian Siswa',
            'siswa' => $siswa
        ];

        dd($siswa);

        return view("pages/penilaian/setting_penilaian", $data);
    }
}
