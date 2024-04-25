<?php

namespace App\Controllers;

use App\Models\PelanggaranModel;
use App\Models\PenghargaanModel;


class TataTertib extends BaseController
{
    protected $pelanggaranModel;
    protected $penghargaanModel;

    public function __construct()
    {
        $this->pelanggaranModel = new PelanggaranModel();
        $this->penghargaanModel = new PenghargaanModel();
    }

    public function index(): string
    {
        $pelanggaran = $this->pelanggaranModel->findAll();
        $penghargaan = $this->penghargaanModel->findAll();

        $data = [
            'title' => 'Setting Penilaian Siswa',
            'pelanggaran' => $pelanggaran,
            'penghargaan' => $penghargaan
        ];

        return view("pages/peraturan/tata_tertib", $data);
    }
}
