<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\TataTertibModel;

class LaporController extends BaseController
{
    protected $siswaModel;
    protected $userModel;
    protected $tataTertibModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
        $this->tataTertibModel = new TataTertibModel();
    }

    public function index(): string
    {
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $siswa = $this->siswaModel->search($keyword);
        } else {
            $siswa = $this->siswaModel;
        }

        $penghargaan = $this->tataTertibModel->getRewards();
        $pelanggaran = $this->tataTertibModel->getViolations();

        $data = [
            'title' => 'Lapor Siswa',
            'siswa' => $siswa->paginate(10, 'siswa'),
            'penghargaan' => $penghargaan,
            'pelanggaran' => $pelanggaran,
            'pager' => $siswa->pager,
        ];

        return view('pages/pelaporan/lapor_siswa', $data);
    }

    public function insertPelanggaran()
    {
        
    }
    public function insertPenghargaan()
    {
    }
}
