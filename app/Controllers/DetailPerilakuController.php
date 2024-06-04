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

    public function delete($id_perilaku)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Dapatkan data perilaku siswa
            $perilaku = $this->detailPerilakuModel->find($id_perilaku);

            if (!$perilaku) {
                throw new \Exception('Data perilaku tidak ditemukan');
            }

            // Dapatkan id_pengakuan dan nisn
            $id_pengakuan = $perilaku['id_pengakuan'];
            $nisn = $perilaku['nisn'];

            // Dapatkan data pengakuan
            $pengakuan = $this->pengakuanModel->find($id_pengakuan);

            if (!$pengakuan) {
                throw new \Exception('Data pengakuan tidak ditemukan');
            }

            // Hapus data perilaku siswa berdasarkan id_perilaku
            $this->detailPerilakuModel->delete($id_perilaku);

            // Hapus data di tabel pengakuan berdasarkan id_pengakuan
            $this->pengakuanModel->delete($id_pengakuan);

            // Dapatkan poin yang harus dikembalikan
            $poinDikembalikan = $pengakuan['poin'];

            // Dapatkan data siswa
            $siswa = $this->siswaModel->where('nisn', $nisn)->first();

            if (!$siswa) {
                throw new \Exception('Data siswa tidak ditemukan');
            }

            // Update poin siswa
            $poinBaru = $siswa['poin'] - $poinDikembalikan;
            $this->siswaModel->update($siswa['nisn'], ['poin' => $poinBaru]);

            // Commit transaksi
            $db->transCommit();

            return redirect()->to('/daftar-perilaku')->with('success', 'Data perilaku berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            $db->transRollback();
            log_message('error', 'Gagal menghapus data perilaku: ' . $e->getMessage());
            return redirect()->to('/daftar-perilaku')->with('error', 'Gagal menghapus data perilaku');
        }
    }
}
