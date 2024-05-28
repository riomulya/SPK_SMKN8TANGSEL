<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\PengakuanModel;

class DashboardController extends BaseController
{
    protected $siswaModel;
    protected $pengakuanModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->pengakuanModel = new PengakuanModel();
    }
    public function index(): string
    {

        // Fetch and group data by 'keterangan'
        $data = $this->pengakuanModel
            ->select('keterangan, COUNT(*) as count')
            ->where('diakui', 'terima')
            ->groupBy('keterangan')
            ->findAll();

        // Prepare data for the chart
        $chartData = $this->prepareChartData($data);

        $data = [
            'title' => "Dashboard Penilaian Karakter",
            'total_siswa' => $this->siswaModel->countAllResults(),
            'total_penghargaan' => $this->pengakuanModel
                ->where('diakui', 'terima')
                ->groupStart()
                ->where('poin > ', 0)
                ->groupEnd()
                ->countAllResults(),
            'total_pelanggaran' => $this->pengakuanModel
                ->where('diakui', 'terima')
                ->groupStart()
                ->where('poin < ', 0)
                ->groupEnd()
                ->countAllResults(),
            'siswa_tertinggi' => $this->siswaModel
                ->orderBy('poin', 'DESC')
                ->findAll(5),
            'siswa_terendah' => $this->siswaModel
                ->orderBy('poin', 'ASC')
                ->findAll(5),
            'chartData' => $chartData,
            'pengakuan' => $this->pengakuanModel->where('diakui', 'terima')->findAll(),
        ];
        if (session('isLoggedIn') && session('role') !== 'siswa') {
            return view('/pages/dashboard/dashboard_admin', $data);
        } else {
            $siswa =  $this->siswaModel->where('email', session('email'))->first();
            $data['siswa'] = $siswa;
            $data['perilaku_siswa'] = $this->pengakuanModel->where('pelaku', $siswa['nisn'])->findAll();
            return view('/pages/dashboard/dashboard_siswa', $data);
        }
    }

    private function prepareChartData($data)
    {
        $labels = [];
        $series = [];

        foreach ($data as $item) {
            $labels[] = $item['keterangan'];
            $series[] = $item['count'];
        }

        return [
            'labels' => $labels,
            'series' => $series,
        ];
    }
}
