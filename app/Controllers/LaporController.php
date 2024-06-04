<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\TataTertibModel;
use App\Models\PengakuanModel;
use App\Models\DetailPerilakuModel;
use Ramsey\Uuid\Uuid;

class LaporController extends BaseController
{
    protected $siswaModel;
    protected $userModel;
    protected $tataTertibModel;
    protected $pengakuanModel;
    protected $detailPerilakuModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
        $this->tataTertibModel = new TataTertibModel();
        $this->pengakuanModel = new PengakuanModel();
        $this->detailPerilakuModel = new DetailPerilakuModel();
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

    public function insertPelanggaran($idSiswa)
    {
        $pelanggaran = $this->request->getVar('state_pelanggaran');

        try {

            $count = 0;
            $message = "";
            foreach ($pelanggaran as $idTataTertib) {
                // Mengambil detail tata tertib dari model
                $detail = $this->tataTertibModel->find($idTataTertib);

                $uuid = Uuid::uuid4()->toString();
                $deskripsi = $this->request->getPost('deskripsi');

                if (session('role') == 'admin' || session('role') == 'guru') {
                    $diakui =  'terima';
                } else {
                    $diakui =  'pending';
                }

                $data_pelanggaran = [
                    'id_pengakuan' => $uuid,
                    'pelaku' => $idSiswa,
                    'kategori' => $idTataTertib,
                    'keterangan' => $detail['keterangan'],
                    'poin' => $detail['poin'],
                    'diakui' => $diakui,
                    'pelapor' => session('role'),
                    'deskripsi' => $deskripsi,
                    'updatedAt' => date('Y-m-d H:i:s'),
                    'createdAt' => date('Y-m-d H:i:s'),
                ];

                $id_perilaku = Uuid::uuid4()->toString();

                $data_detail_perilaku = [
                    'id_perilaku' => $id_perilaku,
                    'nisn' => $idSiswa,
                    'id_pengakuan' => $uuid,
                    'updatedAt' => date('Y-m-d H:i:s'),
                    'createdAt' => date('Y-m-d H:i:s'),
                ];

                $this->pengakuanModel->insert($data_pelanggaran);

                $this->detailPerilakuModel->insert($data_detail_perilaku);

                $siswa = $this->siswaModel->find($idSiswa);
                $poinSebelum = $siswa['poin'];
                $poinSesudah = [
                    'poin' => $poinSebelum + $detail['poin'],
                ];
                $this->siswaModel->update($idSiswa, $poinSesudah);
                // Memasukkan detail tata tertib ke dalam array
                $detailTataTertib[] = $detail;
                $count++;
                $message .= "<li>" . $detail["keterangan"] . "</li>";
            }

            $emailContent = $this->createEmailTemplate("Anda Melakukan Perilaku Negatif", $deskripsi . "<ul>" . $message . "</ul>", 'negative');
            $this->sentEmail($siswa["email"], 'riomulya79@gmail.com', "Anda Melakukan Perilaku Negatif", $emailContent);
            $message = 'Berhasil melapor ' . $count . ' pelanggaran';
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat melapor');
        }
    }

    public function insertPenghargaan($idSiswa)
    {
        $penghargaan = $this->request->getVar('state_penghargaan');

        try {
            $count = 0;
            $message = "";
            foreach ($penghargaan as $idTataTertib) {
                // Mengambil detail tata tertib dari model
                $detail = $this->tataTertibModel->find($idTataTertib);

                $deskripsi = $this->request->getPost('deskripsi');

                $uuid = Uuid::uuid4()->toString();

                if (session('role') == 'admin' || session('role') == 'guru') {
                    $diakui =  'terima';
                } else {
                    $diakui =  'pending';
                }

                $data_penghargaan = [
                    'id_pengakuan' => $uuid,
                    'pelaku' => $idSiswa,
                    'kategori' => $idTataTertib,
                    'keterangan' => $detail['keterangan'],
                    'poin' => $detail['poin'],
                    'diakui' => $diakui,
                    'deskripsi' => $deskripsi,
                    'pelapor' => session('role'),
                    'updatedAt' => date('Y-m-d H:i:s'),
                    'createdAt' => date('Y-m-d H:i:s'),
                ];

                $id_perilaku = Uuid::uuid4()->toString();

                $data_detail_perilaku = [
                    'id_perilaku' => $id_perilaku,
                    'nisn' => $idSiswa,
                    'id_pengakuan' => $uuid,
                    'updatedAt' => date('Y-m-d H:i:s'),
                    'createdAt' => date('Y-m-d H:i:s'),
                ];

                $this->pengakuanModel->insert($data_penghargaan);

                $this->detailPerilakuModel->insert($data_detail_perilaku);

                $siswa = $this->siswaModel->find($idSiswa);
                $poinSebelum = $siswa['poin'];
                $poinSesudah = [
                    'poin' => $poinSebelum + $detail['poin'],
                ];
                $this->siswaModel->update($idSiswa, $poinSesudah);

                $count++;
                $message .= "<li>" . $detail["keterangan"] . "</li>";
            }

            $emailContent = $this->createEmailTemplate("Anda Melakukan Perilaku Positif", $deskripsi . "<ul>" . $message . "</ul>", 'positive');
            $this->sentEmail($siswa["email"], 'joygaming765@gmail.com', "Anda Melakukan Perilaku Positif", $emailContent);
            $message = 'Berhasil melapor ' . $count . ' penghargaan';
            return redirect()->to('/lapor')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->to('/lapor')->with('error', 'Terjadi kesalahan saat melapor');
        }
    }

    public function createEmailTemplate($subject, $body, $type)
    {
        $color = $type === 'positive' ? '#4CAF50' : '#F44336';
        $sub = $type === 'positive' ? '<p>Terima kasih telah melakukan hal baik</p>' : '<p>Anda melakukan tindakan yang meanggar peraturan sekolah</p>';
        $foot = $type === 'positive' ? '<p>Tingkatkan dan pertahankan lagi prestasi anda</p>' : '<p>Tingkatkan lagi prestasi anda untuk mengembalikan poin anda , jika anda tidak merasa melakukan perbuatan ini laporkan ke bagian admin</p>';
        $template = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
                    .header { background-color: $color; color: #ffffff; padding: 20px; text-align: center; }
                    .header h2 { margin: 0; }
                    .content { padding: 20px; color: #333333; }
                    .footer { background-color: #f4f4f4; color: #666666; padding: 10px; text-align: center; border-top: 1px solid #e6e6e6; }
                    .footer p { margin: 0; }
                    ul { padding-left: 20px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>$subject</h2>
                    </div>
                    <div class='sub'>
                        $sub
                    </div>
                    <div class='content'>
                        <p>$body</p>
                    </div>
                    <div class='foot'>
                        $foot
                    </div>
                    <div class='footer'>
                        <p>Terima kasih atas perhatian Anda.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        return $template;
    }

    public function sentEmail($penerima, $pengirim, $subject, $message)
    {
        $email = \Config\Services::email();

        $email->setTo($penerima);
        $email->setFrom($pengirim);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            return redirect()->to('/lapor')->with('success', 'Email berhasil dikirim');
        } else {
            $error_message = $email->printDebugger(['headers']);
            return redirect()->to('/lapor')->with('error', 'Gagal mengirim email: ' . $error_message);
        }
    }
}
