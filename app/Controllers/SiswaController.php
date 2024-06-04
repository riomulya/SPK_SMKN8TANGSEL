<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\PengakuanModel;
use App\Models\TataTertibModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SiswaController extends BaseController
{
    protected $siswaModel;
    protected $userModel;
    protected $pengakuanModel;
    protected $tataTertibModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
        $this->pengakuanModel = new PengakuanModel();
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
        $data = [
            'title' => 'Settings Data siswa',
            'siswa' => $siswa->paginate(10, 'siswa'),
            'pager' => $siswa->pager
        ];

        return view("pages/settings/siswa", $data);
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

    public function detailSiswa($nisn)
    {
        $siswa = $this->siswaModel->find($nisn);
        if (!$siswa) {
            throw new PageNotFoundException("Siswa dengan NISN $nisn tidak ditemukan");
        }
        $perilaku_siswa = $this->pengakuanModel->where('pelaku', $nisn)->where('diakui', 'terima')->findAll();
        $penghargaan = $this->tataTertibModel->getRewards();
        $pelanggaran = $this->tataTertibModel->getViolations();
        $data = [
            'title' => 'Daftar Siswa',
            'siswa' => $siswa,
            'perilaku_siswa' => $perilaku_siswa,
            'chartDataPerilakuSiswa' => $this->getChartByMonth($nisn),
            'penghargaan' => $penghargaan,
            'pelanggaran' => $pelanggaran
        ];

        if (!empty($this->getChartByMonth($nisn))) {
            // Jika $chartDataPerilakuSiswa tidak kosong, kirimkan ke view
            // return  print_r($this->getChartByMonth($nisn));
            return view('/pages/dashboard/dashboard_siswa', $data);
        } else {
            // Jika $chartDataPerilakuSiswa kosong, lakukan sesuatu, misalnya tampilkan pesan error
            echo "Data chart perilaku siswa kosong";
        }

        // return view('/pages/dashboard/dashboard_siswa', $data);
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Ambil data siswa berdasarkan NISN
            $siswa = $this->siswaModel->find($id);

            if (!$siswa) {
                return redirect()->to('/settings/siswa')->with('error', 'Data siswa tidak ditemukan.');
            }

            // Hapus data dari tabel 'siswa'
            if (!$this->siswaModel->delete($id)) {
                $error = $this->siswaModel->errors();
                $db->transRollback();
                log_message('error', 'Gagal menghapus data siswa : ');
                return redirect()->to('/settings/siswa')->with('error', 'Gagal menghapus data siswa digunakan di table lain ');
            }

            // Hapus data dari tabel 'users' berdasarkan email
            if (!$this->userModel->delete($siswa['email'])) {
                $error = $this->userModel->errors();
                $db->transRollback();
                log_message('error', 'Gagal menghapus data user : ');
                return redirect()->to('/settings/siswa')->with('error', 'Gagal menghapus data user');
            }

            // Selesaikan transaksi
            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                log_message('error', 'Transaksi gagal.');
                return redirect()->to('/settings/siswa')->with('error', 'Transaksi gagal.');
            } else {
                $db->transCommit();
                return redirect()->to('/settings/siswa')->with('success', 'Data berhasil dihapus.');
            }
        } catch (DatabaseException $e) {
            $db->transRollback();

            log_message('error', 'Kesalahan database: ' . $e->getMessage());
            return redirect()->to('/settings/siswa')->with('error', 'Data Digunakan di table lain');
        }
    }


    /**
     * Inserts a new student into the database.
     *
     * Validates the input data and inserts a new record into the 'users' and 'students' tables.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects to '/settings/siswa' with a success or error message.
     */
    public function insert()
    {
        // Validasi Data Yang Masuk
        $validationRules = [
            'nisn' => 'required',
            'email' => 'required|valid_email',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        // Ambil data dari request
        $nisn = $this->request->getPost('nisn');
        $email = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $tanggal_lahir = $this->request->getPost('tanggal_lahir');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $kelas = $this->request->getPost('kelas');
        $poin = 100;

        // Ensure $password is assigned correctly
        $password = str_replace('-,/', '', $tanggal_lahir);

        // Mulai transaksi
        $db = \Config\Database::connect();
        $db->transStart();

        /** @var string $password */
        /** @var string $tanggal_lahir */
        $tanggal_lahir_formatted = date('Y-m-d', strtotime($tanggal_lahir));
        $password = str_replace('-', '', $tanggal_lahir_formatted);

        try {
            // Insert ke tabel 'users'
            $userData = [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'siswa',
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->userModel->insert($userData);

            // Insert ke tabel 'siswa'
            $siswaData = [
                'nisn' => $nisn,
                'email' => $email,
                'nama' => $nama,
                'tanggal_lahir' => $tanggal_lahir_formatted,
                'jenis_kelamin' => $jenis_kelamin,
                'kelas' => $kelas,
                'poin' => $poin,
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->siswaModel->insert($siswaData);

            // Commit transaksi
            $db->transCommit();

            return redirect()->to('/settings/siswa')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            $db->transRollback();
            return redirect()->to('/settings/siswa')->with('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
        }
    }

    public function update(string $nisn)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Validasi input dari form
            $validation = \Config\Services::validation();
            $validation->setRules([
                'email' => 'required|valid_email',
                'nama' => 'required',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'kelas' => 'required'
            ]);

            // Jalankan validasi
            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Ambil data dari form
            $emailBaru = $this->request->getPost('email');
            $nama = $this->request->getPost('nama');
            $tanggal_lahir = $this->request->getPost('tanggal_lahir');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $kelas = $this->request->getPost('kelas');

            /** @var string $tanggal_lahir */
            $tanggal_lahir_formatted = date('Y-m-d', strtotime($tanggal_lahir));

            // Ambil email lama dari database berdasarkan nisn
            $siswa = $this->siswaModel->find($nisn);
            if (!$siswa) {
                return redirect()->to('/settings/siswa')->with('error', 'Data siswa tidak ditemukan.');
            }
            $emailLama = $siswa['email'];

            // Update data siswa
            $dataSiswa = [
                'email' => $emailBaru,
                'nama' => $nama,
                'tanggal_lahir' => $tanggal_lahir_formatted,
                'jenis_kelamin' => $jenis_kelamin,
                'kelas' => $kelas
            ];

            // Generate password baru dari tanggal lahir
            $password = str_replace('-', '', $tanggal_lahir);

            // Insert user baru
            $userData = [
                'email' => $emailBaru,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'siswa',
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            if ($emailBaru !== $emailLama) {
                $this->userModel->insert($userData);
            }

            // Update data siswa
            $this->siswaModel->update($nisn, $dataSiswa);

            if ($emailLama !== $emailBaru) {
                // Hapus user lama
                $deleteResult = $this->userModel->where('email', $emailLama)->delete();

                // Tambahkan log untuk memastikan penghapusan berjalan
                if ($deleteResult === false) {
                    log_message('error', 'Gagal menghapus user lama dengan email: ' . $emailLama);
                    return redirect()->to('/settings/siswa')->with('error', 'Gagal menghapus user lama.');
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/settings/siswa')->with('error', 'Gagal memperbarui data siswa.');
            }

            return redirect()->to('/settings/siswa')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/settings/siswa')->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    //TODO: mengambil data pengakuan penghargaan dan pelanggaran 
    //TODO: berdasarkan 3 bulan terakhir
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

    public function export()
    {
        $siswa = $this->siswaModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['NISN', 'Email', 'Nama', 'Tanggal Lahir', 'Jenis Kelamin', 'Kelas', 'Poin'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Styling header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFE599');
        $sheet->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Data
        $row = 2;
        foreach ($siswa as $s) {
            $sheet->setCellValue('A' . $row, $s['nisn']);
            $sheet->setCellValue('B' . $row, $s['email']);
            $sheet->setCellValue('C' . $row, $s['nama']);
            $sheet->setCellValue('D' . $row, $s['tanggal_lahir']);
            $sheet->setCellValue('E' . $row, $s['jenis_kelamin']);
            $sheet->setCellValue('F' . $row, $s['kelas']);
            $sheet->setCellValue('G' . $row, $s['poin']);

            // Styling data rows
            $sheet->getStyle('A' . $row . ':G' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $row++;
        }

        // Set column widths
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_siswa.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
