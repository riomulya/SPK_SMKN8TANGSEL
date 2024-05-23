<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $userModel = new UserModel();

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Ambil data pengguna berdasarkan email
            $user = $userModel->where('email', $email)->first();
            /** @var string $password */

            if ($user) {
                // Verifikasi password
                if (password_verify($password, $user['password'])) {
                    // Berhasil login, set session atau lakukan tindakan lainnya
                    // Contoh: set session untuk user yang login
                    $session = session();
                    $session->set([
                        // 'user_id' => $user['id'],
                        'email' => $user['email'],
                        // Tambahkan data lain yang ingin Anda simpan dalam session
                    ]);
                    // Redirect ke halaman dashboard atau halaman setelah login sukses
                    return redirect()->to('/dashboard');
                } else {
                    // Password tidak cocok
                    return redirect()->back()->withInput()->with('error', 'Password yang Anda masukkan salah.');
                }
            } else {
                // Pengguna tidak ditemukan
                return redirect()->back()->withInput()->with('error', 'Email yang Anda masukkan tidak terdaftar.');
            }
        } else {
            // Validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Tampilkan halaman login jika tidak ada post data
        return view('login_page');
    }

    // Metode logout
    public function logout()
    {
        // Hapus session atau lakukan tindakan logout lainnya
        $session = session();
        $session->destroy();

        // Redirect ke halaman login setelah logout
        return redirect()->to('');
    }
}
