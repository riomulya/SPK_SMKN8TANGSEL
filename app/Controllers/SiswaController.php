<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\Uuid;

class SiswaController extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index(): string
    {
        $siswa = $this->siswaModel->findAll();

        $data = [
            'title' => 'pelangaran siswa',
            'siswa' => $siswa
        ];

        dd($siswa);

        return view("");
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

    public function detailSiswa($nisn): string
    {
        $siswa = $this->siswaModel->find($nisn);

        $data = [
            'title' => 'Daftar Siswa',
            'siswa' => $siswa
        ];


        return view('pages/detail_siswa', $data);
    }
    public function delete($id)
    {
        try {
            // $this->tataTertibModel->delete($id);
            return redirect()->to('/settings/tata-tertib')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            if ($e->getCode() == 1451) {
                // Jika terjadi kesalahan karena kunci asing
                return redirect()->to('/settings/tata-tertib')->with('error', 'Tidak dapat menghapus data. data tersebut sudah digunakan di tempat lain.');
            } else {
                // Jika terjadi kesalahan lain
                return redirect()->to('/settings/tata-tertib')->with('error', 'Gagal memperbarui data.');
            }
        }
    }

    public function insert()
    {
        // Validasi Data Yang Masuk
        $validationRules = [
            'kategori' => 'required',
            'keterangan' => 'required',
            'type' => 'required',
            'poin' => 'required|numeric'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        // Tetapkan ID secara otomatis menggunakan uuid ci4
        $uuid = Uuid::uuid4()->toString();

        // Ambil data dari request
        $kategori = $this->request->getPost('kategori');
        $keterangan = $this->request->getPost('keterangan');
        $type = $this->request->getPost('type');
        $poin = $this->request->getPost('poin');

        // Insert data kedalam database
        $data = [
            'id' => $uuid,
            'kategori' => $kategori,
            'keterangan' => $keterangan,
            'type' => $type,
            'poin' => $poin,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ];

        try {
            // $this->tataTertibModel->insert($data);
            return redirect()->to('/settings/tata-tertib')->with('success', 'Data berhasil ditambahkan.');
        } catch (DatabaseException $e) {
            $error_message = "Tidak dapat menambahkan data";
            return redirect()->to('/settings/tata-tertib')->with('error', $error_message);
        }
    }

    public function update(string $id)
    {
        try {
            // Validasi input dari form
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'kategori' => 'required',
                'keterangan' => 'required',
                'type' => 'required',
                'poin' => 'required|numeric'
            ]);

            // Jalankan validasi
            if (!$validation->withRequest($this->request)->run()) {
                // Jika validasi gagal, kirimkan pesan kesalahan
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Ambil data dari form
            $data = [
                'kategori' => $this->request->getPost('kategori'),
                'keterangan' => $this->request->getPost('keterangan'),
                'type' => $this->request->getPost('type'),
                'poin' => $this->request->getPost('poin'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            // Lakukan pembaruan data di sini
            // $this->tataTertibModel->update($id, $data);

            return redirect()->to('/settings/tata-tertib')->with('success', 'Data berhasil diperbarui.');
        } catch (DatabaseException $e) {
            // Tangani kesalahan saat memperbarui data
            if ($e->getCode() == 1451) {
                // Jika terjadi kesalahan karena kunci asing
                return redirect()->to('/settings/tata-tertib')->with('error', 'Gagal memperbarui data. Kategori tersebut sudah digunakan di tempat lain.');
            } else {
                // Jika terjadi kesalahan lain
                return redirect()->to('/settings/tata-tertib')->with('error', 'Gagal memperbarui data.');
            }
        }
    }
}
