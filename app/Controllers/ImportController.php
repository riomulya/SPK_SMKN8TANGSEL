<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\TataTertibModel;

class ImportController extends BaseController
{

    protected $siswaModel;
    protected $userModel;
    protected $guruModel;
    protected $tataTertibModel;
    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
        $this->guruModel = new GuruModel();
        $this->tataTertibModel = new TataTertibModel();
    }

    public function importDataSiswa()
    {
        $file = $this->request->getFile('file_input_siswa');

        // Pastikan file telah diunggah
        if ($file && $file->isValid() && in_array($file->getExtension(), ['xlsx', 'xls'])) {
            // Load file Excel
            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();

            $db = \Config\Database::connect();
            $db->transStart();

            try {

                foreach ($worksheet->getRowIterator() as $row) {
                    // Skip header row
                    if ($row->getRowIndex() === 1) {
                        continue;
                    }

                    $rowData = [];
                    foreach ($row->getCellIterator() as $cell) {
                        $rowData[] = $cell->getFormattedValue();
                    }

                    // Buat password berdasarkan tanggal lahir siswa
                    // $tanggal_lahir_obj = \DateTime::createFromFormat('m/d/Y', $rowData[3]); // Parse tanggal dari format Excel
                    // $tanggal_lahir_formatted = $tanggal_lahir_obj->format('Y-m-d'); // Konversi ke format yang sesuai
                    // $tanggal_lahir_formatted = date('Y-m-d', strtotime($rowData[3])); // Indeks 3 untuk 'tanggal_lahir'
                    $password = str_replace('-', '', $rowData[3]);

                    // Buat entri pengguna baru
                    $userData = [
                        'email' => $rowData[1], // Indeks 1 untuk 'email'
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'role' => 'siswa',
                        'createdAt' => date('Y-m-d H:i:s'),
                        'updatedAt' => date('Y-m-d H:i:s')
                    ];
                    $this->userModel->insert($userData);

                    // Tambahkan data siswa ke dalam array
                    $siswaData = [
                        'nisn' => $rowData[0], // Indeks 0 untuk 'nisn'
                        'email' => $rowData[1], // Indeks 1 untuk 'email'
                        'nama' => $rowData[2], // Indeks 2 untuk 'nama'
                        'tanggal_lahir' => $rowData[3], // Indeks 3 untuk 'tanggal_lahir'
                        'jenis_kelamin' => $rowData[4], // Indeks 4 untuk 'jenis_kelamin'
                        'kelas' => $rowData[5], // Indeks 5 untuk 'kelas'
                        'poin' => 100, // Atur poin awal sesuai kebutuhan
                        'createdAt' => date('Y-m-d H:i:s'),
                        'updatedAt' => date('Y-m-d H:i:s')
                    ];

                    // Insert data siswa
                    $this->siswaModel->insert($siswaData);
                }


                // Commit transaksi
                $db->transCommit();

                return redirect()->to('/settings/siswa')->with('success', "Berhasil import data siswa");
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                $db->transRollback();
                log_message('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
                return redirect()->to('/settings/siswa')->with('error', 'Data Gagal Di import');
            }
        }

        return redirect()->to('/settings/siswa')->with('error', 'Invalid file format or file is not uploaded.');
    }

    public function importDataGuru()
    {
        $file = $this->request->getFile('file_input_guru');

        // Pastikan file telah diunggah
        if ($file && $file->isValid() && in_array($file->getExtension(), ['xlsx', 'xls'])) {
            // Load file Excel
            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();

            $db = \Config\Database::connect();
            $db->transStart();

            try {

                foreach ($worksheet->getRowIterator() as $row) {
                    // Skip header row
                    if ($row->getRowIndex() === 1) {
                        continue;
                    }

                    $rowData = [];
                    foreach ($row->getCellIterator() as $cell) {
                        $rowData[] = $cell->getFormattedValue();
                    }

                    // Buat password berdasarkan tanggal lahir guru
                    $password = str_replace('-', '', $rowData[3]);

                    // Buat entri pengguna baru
                    $userData = [
                        'email' => $rowData[1], // Indeks 1 untuk 'email'
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'role' => 'guru',
                        'createdAt' => date('Y-m-d H:i:s'),
                        'updatedAt' => date('Y-m-d H:i:s')
                    ];
                    $this->userModel->insert($userData);

                    // Tambahkan data guru ke dalam array
                    $guruData = [
                        'nip' => $rowData[0], // Indeks 0 untuk 'nip'
                        'email' => $rowData[1], // Indeks 1 untuk 'email'
                        'nama' => $rowData[2], // Indeks 5 untuk 'nama'
                        'tanggal_lahir' => $rowData[3], // Indeks 2 untuk 'tanggal_lahir'
                        'jenis_kelamin' => $rowData[4], // Indeks 3 untuk 'jenis_kelamin'
                        'kelas_mengajar' => $rowData[5], // Indeks 4 untuk 'kelas_mengajar'
                        'createdAt' => date('Y-m-d H:i:s'),
                        'updatedAt' => date('Y-m-d H:i:s')
                    ];

                    // Insert data guru
                    $this->guruModel->insert($guruData);
                }

                // Commit transaksi
                $db->transCommit();

                return redirect()->to('/settings/guru')->with('success', "Berhasil import data guru");
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                $db->transRollback();
                log_message('error', 'Gagal menambahkan data guru: ' . $e->getMessage());
                return redirect()->to('/settings/guru')->with('error', 'Data Gagal Di import');
            }
        }

        return redirect()->to('/settings/guru')->with('error', 'Invalid file format or file is not uploaded.');
    }


    public function importDataTataTertib()
    {
        $file = $this->request->getFile('file_input_tata_tertib');

        // Pastikan file telah diunggah dan valid
        if ($file && $file->isValid() && in_array($file->getExtension(), ['xlsx', 'xls'])) {
            // Load file Excel
            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();

            $db = \Config\Database::connect();
            $db->transStart();

            try {
                foreach ($worksheet->getRowIterator() as $row) {
                    // Skip header row
                    if ($row->getRowIndex() === 1) {
                        continue;
                    }

                    $rowData = [];
                    foreach ($row->getCellIterator() as $cell) {
                        $rowData[] = $cell->getFormattedValue();
                    }

                    // Tambahkan data tata tertib ke dalam array
                    $tataTertibData = [
                        'id' => $rowData[0], // Indeks 0 untuk 'id'
                        'keterangan' => $rowData[1], // Indeks 1 untuk 'keterangan'
                        'kategori' => $rowData[2], // Indeks 2 untuk 'kategori'
                        'poin' => $rowData[3], // Indeks 3 untuk 'poin'
                        'type' => $rowData[4], // Indeks 4 untuk 'type'
                        'createdAt' => date('Y-m-d H:i:s'), // Indeks 5 untuk 'createdAt'
                        'updatedAt' => date('Y-m-d H:i:s'), // Indeks 6 untuk 'updatedAt'
                    ];

                    // Insert data tata tertib
                    $this->tataTertibModel->insert($tataTertibData);
                }

                // Commit transaksi
                $db->transCommit();

                return redirect()->to('/settings/tata-tertib')->with('success', "Berhasil import data tata tertib");
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                $db->transRollback();
                log_message('error', 'Gagal menambahkan data tata tertib: ' . $e->getMessage());
                return redirect()->to('/settings/tata-tertib')->with('error', 'Data gagal diimpor');
            }
        }

        return redirect()->to('/settings/tata-tertib')->with('error', 'Format file tidak valid atau file tidak diunggah');
    }
}
