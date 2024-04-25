<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Pages extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function pelanggaran(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Pelanggaran Siswa',
            'siswa' => $siswa
        ];


        return view('pages/pelanggaran', $data);
    }

    public function penghargaan(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Penghargaan Siswa',
            'siswa' => $siswa
        ];


        return view('pages/penghargaan', $data);
    }

    public function dashboard(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Dashboard',
            'siswa' => $siswa
        ];


        return view('pages/dashboard', $data);
    }
}
