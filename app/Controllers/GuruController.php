<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GuruController extends BaseController
{
    protected $guruModel;
    protected $userModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->userModel = new UserModel();
    }

    public function index(): string
    {
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $guru = $this->guruModel->search($keyword);
        } else {
            $guru = $this->guruModel;
        }

        $guru = $this->guruModel->paginate(10, 'guru');

        $data = [
            'title' => 'Settings Data Guru',
            'guru' => $guru,
            'pager' => $this->guruModel->pager
        ];

        return view('pages/settings/guru', $data);
    }

    public function insert()
    {
        // Validasi Data Yang Masuk
        $validationRules = [
            'nip' => 'required',
            'email' => 'required|valid_email',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_mengajar' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        // Ambil data dari request
        $nip = $this->request->getPost('nip');
        $email = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $tanggal_lahir = $this->request->getPost('tanggal_lahir');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $kelas_mengajar = $this->request->getPost('kelas_mengajar');
        $role = "guru";

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
                'role' => $role,
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->userModel->insert($userData);

            // Insert ke tabel 'guru'
            $guruData = [
                'nip' => $nip,
                'email' => $email,
                'nama' => $nama,
                'tanggal_lahir' => $tanggal_lahir_formatted,
                'jenis_kelamin' => $jenis_kelamin,
                'kelas_mengajar' => $kelas_mengajar,
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->guruModel->insert($guruData);

            // Commit transaksi
            $db->transCommit();

            return redirect()->to('/settings/guru')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            $db->transRollback();
            return redirect()->to('/settings/guru')->with('error', 'Gagal menambahkan data guru: ' . $e->getMessage());
        }
    }

    public function update(string $nip)
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
                'kelas_mengajar' => 'required'
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
            $kelas_mengajar = $this->request->getPost('kelas_mengajar');

            /** @var string $tanggal_lahir */
            $tanggal_lahir_formatted = date('Y-m-d', strtotime($tanggal_lahir));

            // Ambil email lama dari database berdasarkan nip
            $guru = $this->guruModel->find($nip);
            if (!$guru) {
                return redirect()->to('/settings/guru')->with('error', 'Data guru tidak ditemukan.');
            }
            $emailLama = $guru['email'];

            // Update data guru
            $dataGuru = [
                'email' => $emailBaru,
                'nama' => $nama,
                'tanggal_lahir' => $tanggal_lahir_formatted,
                'jenis_kelamin' => $jenis_kelamin,
                'kelas_mengajar' => $kelas_mengajar,
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            // Generate password baru dari tanggal lahir
            $password = str_replace('-', '', $tanggal_lahir_formatted);

            // Insert user baru
            $userData = [
                'email' => $emailBaru,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'guru',
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            if ($emailLama !== $emailBaru) {
                $this->userModel->insert($userData);
            }

            // Update data guru
            $this->guruModel->update($nip, $dataGuru);

            if ($emailLama !== $emailBaru) {
                // Hapus user lama
                $deleteResult = $this->userModel->where('email', $emailLama)->delete();

                // Tambahkan log untuk memastikan penghapusan berjalan
                if ($deleteResult === false) {
                    log_message('error', 'Gagal menghapus user lama dengan email: ' . $emailLama);
                    return redirect()->to('/settings/guru')->with('error', 'Gagal menghapus user lama.');
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/settings/guru')->with('error', 'Gagal memperbarui data guru.');
            }

            return redirect()->to('/settings/guru')->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/settings/guru')->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Ambil data guru berdasarkan NIP
            $guru = $this->guruModel->find($id);

            if (!$guru) {
                return redirect()->to('/settings/guru')->with('error', 'Data guru tidak ditemukan.');
            }

            // Hapus data dari tabel 'guru'
            if (!$this->guruModel->delete($id)) {
                $error = $this->guruModel->errors();
                $db->transRollback();
                log_message('error', 'Gagal menghapus data guru: ' . $error);
                return redirect()->to('/settings/guru')->with('error', 'Gagal menghapus data guru digunakan di table lain');
            }

            // Hapus data dari tabel 'users' berdasarkan email
            if (!$this->userModel->delete($guru['email'])) {
                $error = $this->userModel->errors();
                $db->transRollback();
                log_message('error', 'Gagal menghapus data user: ' . $error);
                return redirect()->to('/settings/guru')->with('error', 'Gagal menghapus data user');
            }

            // Selesaikan transaksi
            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                log_message('error', 'Transaksi gagal.');
                return redirect()->to('/settings/guru')->with('error', 'Transaksi gagal.');
            } else {
                $db->transCommit();
                return redirect()->to('/settings/guru')->with('success', 'Data berhasil dihapus.');
            }
        } catch (DatabaseException $e) {
            $db->transRollback();

            log_message('error', 'Kesalahan database: ' . $e->getMessage());
            return redirect()->to('/settings/guru')->with('error', 'Data digunakan di table lain');
        }
    }

    public function export()
    {
        $guru = $this->guruModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['NIP', 'Email', 'Nama', 'Tanggal Lahir', 'Jenis Kelamin', 'Kelas Mengajar'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Styling header
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFE599');
        $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Data
        $row = 2;
        foreach ($guru as $g) {
            $sheet->setCellValue('A' . $row, $g['nip']);
            $sheet->setCellValue('B' . $row, $g['email']);
            $sheet->setCellValue('C' . $row, $g['nama']);
            $sheet->setCellValue('D' . $row, $g['tanggal_lahir']);
            $sheet->setCellValue('E' . $row, $g['jenis_kelamin']);
            $sheet->setCellValue('F' . $row, $g['kelas_mengajar']);

            // Styling data rows
            $sheet->getStyle('A' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $row++;
        }

        // Set column widths
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_guru.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
