<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\TataTertibModel;

class SettingsController extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $tataTertibModel;


    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->tataTertibModel = new TataTertibModel;
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

    // public function tataTertib(): string
    // {
    //     $tata_tertib = $this->tataTertibModel->findAll();
    //     $data = [
    //         'title' => 'Tata Tertib Siswa',
    //         'tata_tertib' => $tata_tertib
    //     ];
    //     return view('pages/settings/tata_tertib', $data);
    // }

    // public function deleteTataTertib($id)
    // {
    //     try {
    //         $this->tataTertibModel->delete($id);
    //         return redirect()->to('/settings/tata-tertib')->with('success', 'Data berhasil dihapus.');
    //     } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
    //         $error_message = "Tidak dapat menghapus item";
    //         return redirect()->to('/settings/tata-tertib')->with('error', $error_message);
    //     }
    // }
}
