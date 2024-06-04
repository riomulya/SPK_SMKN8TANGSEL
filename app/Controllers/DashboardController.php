<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\PengakuanModel;
use App\Models\TataTertibModel;

class DashboardController extends BaseController
{
    protected $siswaModel;
    protected $pengakuanModel;
    protected $tataTertibModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->pengakuanModel = new PengakuanModel();
        $this->tataTertibModel = new TataTertibModel();
    }
    public function index(): string
    {
        //? Fetch and group data by 'keterangan'
        $data = $this->pengakuanModel
            ->select('keterangan, COUNT(*) as count')
            ->where('diakui', 'terima')
            ->groupBy('keterangan')
            ->findAll();

        // TODO: Prepare data for the chart
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
            $penghargaan = $this->tataTertibModel->getRewards();
            $pelanggaran = $this->tataTertibModel->getViolations();
            $siswa =  $this->siswaModel->where('email', session('email'))->first();
            $data['siswa'] = $siswa;
            $data['perilaku_siswa'] = $this->pengakuanModel->where('pelaku', $siswa['nisn'])->findAll();
            $data['chartDataPerilakuSiswa'] = $this->getChartByMonth($siswa["nisn"]);
            $data['penghargaan'] = $penghargaan;
            $data['pelanggaran'] = $pelanggaran;
            return view('/pages/dashboard/dashboard_siswa', $data);
        }
    }

    //TODO: membuat chart untuk semua perilaku untuk dashboard admin
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

    /**  
     * TODO: mengambil data pengakuan penghargaan dan pelanggaran 
     * TODO: berdasarkan 3 bulan terakhir
     */

    public function getChartByMonth($nisn)
    {

        // Mengambil data penghargaan dan pelanggaran untuk siswa dengan $nisn dari tanggal tiga bulan yang lalu hingga sekarang
        $rewardData = $this->pengakuanModel
            ->select("MONTH(createdAt) as month, SUM(poin) as total_poin")
            ->where('diakui', 'terima')
            ->where('poin >', 0)
            ->where('pelaku', $nisn)

            ->groupBy('MONTH(createdAt)')
            ->findAll();

        $violationData = $this->pengakuanModel
            ->select("MONTH(createdAt) as month, SUM(ABS(poin)) as total_poin")
            ->where('diakui', 'terima')
            ->where('poin <', 0)
            ->where('pelaku', $nisn)

            ->groupBy('MONTH(createdAt)')
            ->findAll();

        // Mengisi bulan-bulan yang tidak memiliki data dengan total poin 0
        // Inisialisasi array tetap untuk bulan-bulan dalam setahun
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $rewardMap = array_fill_keys($months, 0);
        $violationMap = array_fill_keys($months, 0);

        // Mengisi nilai total poin dari data pengakuan
        foreach ($rewardData as $record) {
            $month = $months[$record['month'] - 1];
            $rewardMap[$month] = $record['total_poin'];
        }

        foreach ($violationData as $record) {
            $month = $months[$record['month'] - 1];
            $violationMap[$month] = $record['total_poin'];
        }

        // Mengembalikan data dalam bentuk array asosiatif
        return [
            'rewardData' => array_values($rewardMap),
            'violationData' => array_values($violationMap)
        ];
    }


    public function ranking()
    {
        //? Fetch and group data by 'keterangan'
        $data = $this->pengakuanModel
            ->select('keterangan, COUNT(*) as count')
            ->where('diakui', 'terima')
            ->groupBy('keterangan')
            ->findAll();

        // TODO: Prepare data for the chart
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


        return view('/pages/dashboard/dashboard_admin', $data);
    }
}
