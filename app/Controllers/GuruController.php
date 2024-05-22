<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

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
        $guru = $this->guruModel->findAll();

        $data = [
            'title' => 'Settings Data Guru',
            'guru' => $guru
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

        // Ensure $password is assigned correctly
        $password = str_replace('-', '', $tanggal_lahir);

        // Mulai transaksi
        $db = \Config\Database::connect();
        $db->transStart();

        /** @var string $password */
        /** @var string $tanggal_lahir */
        $tanggal_lahir_formatted = date('Y-m-d', strtotime($tanggal_lahir));

        try {
            // Insert ke tabel 'users'
            $userData = [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'guru',
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
            $password = str_replace('-', '', $tanggal_lahir);

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
}
