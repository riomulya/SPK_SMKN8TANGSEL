<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Siswa extends BaseController
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
            'title' => 'pelangaran siswa',
            'siswa' => $siswa
        ];

        dd($siswa);

        return view("");
    }

    public function daftarSiswa(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'Daftar Siswa',
            'siswa' => $siswa
        ];


        return view('pages/daftar_siswa', $data);
    }

    public function detailSiswa($nisn): string
    {
        $siswa = $this->siswaModel->find($nisn);

        $data = [
            'title' => 'Daftar Siswa',
            'siswa' => $siswa
        ];


        return view('pages/detail_siswa', $data);
    }
}
