<?php

namespace App\Controllers;

use App\Models\DetailPerilakuModel;
use App\Models\PengakuanModel;
use App\Models\SiswaModel;

class DetailPerilakuController extends BaseController
{
    protected $detailPerilakuModel;
    protected $pengakuanModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->detailPerilakuModel = new DetailPerilakuModel();
        $this->pengakuanModel = new PengakuanModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $detail_perilaku = $this->detailPerilakuModel->like('nisn', $keyword)->paginate(10, 'detail_perilaku_siswa');
        } else {
            $detail_perilaku = $this->detailPerilakuModel->paginate(10, 'detail_perilaku_siswa');
        }

        $pager = $this->detailPerilakuModel->pager;

        $data = [];
        foreach ($detail_perilaku as $dp) {
            $pengakuan = $this->pengakuanModel->where('id_pengakuan', $dp['id_pengakuan'])->first();
            $siswa = $this->siswaModel->where('nisn', $dp['nisn'])->first();

            if ($pengakuan !== null && $siswa !== null) {
                $data[] = [
                    'detail_perilaku' => $dp,
                    'pengakuan' => $pengakuan,
                    'siswa' => $siswa,
                ];
            }
        }

        return view('pages/daftar_perilaku', [
            'title' => 'Detail Perilaku Siswa',
            'data' => $data,
            'pager' => $pager,
        ]);
    }
}
