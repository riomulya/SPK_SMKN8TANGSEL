<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\SiswaModel;

class Settings extends BaseController
{
    protected $siswaModel;
    protected $guruModel;


    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        helper('date');
    }

    public function index(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Settings Data siswa',
            'siswa' => $siswa
        ];

        return view("pages/settings/siswa", $data);
    }

    public function guru(): string
    {
        $guru = $this->guruModel->findAll();

        $data = [
            'title' => 'Settings Data Guru',
            'guru' => $guru
        ];


        return view('pages/settings/guru', $data);
    }

    public function tataTertib(): string
    {
        // $siswa = $this->siswaModel->find($nisn);
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Daftar Siswa',
            'siswa' => $siswa
        ];


        return view('pages/settings/siswa', $data);
    }
}
