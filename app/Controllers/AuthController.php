<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Ambil data pengguna berdasarkan email
            $user = $this->userModel->where('email', $email)->first();
            /** @var string $password */

            if ($user) {
                // Log email dan hash password untuk verifikasi
                log_message('debug', 'Email: ' . $email);
                log_message('debug', 'Input Password: ' . $password);
                log_message('debug', 'Input Hashed Password: ' . password_hash($password, PASSWORD_DEFAULT));
                log_message('debug', 'Hashed Password from DB: ' . $user['password']);
                log_message('debug', 'email from DB: ' . $user['email']);
                log_message('debug', 'Check Valid: ' . password_verify($password, $user['password']));
                log_message('debug', 'Check Valid: ' . password_verify($password, $user['password']));

                // Verifikasi password
                $verifyResult = password_verify(trim($password), $user['password']);

                if ($verifyResult) {
                    // Berhasil login, set session atau lakukan tindakan lainnya
                    $session = session();
                    $session->set([
                        'isLoggedIn' => true,
                        'email' => $user['email'],
                        'role' => $user['role'],
                    ]);
                    return redirect()->to('/dashboard');
                } else {
                    // Password tidak cocok
                    return redirect()->to('/')->withInput()->with('error', 'Password yang Anda masukkan salah.');
                }
            } else {
                // Pengguna tidak ditemukan
                return redirect()->to('/')->withInput()->with('error', 'Email yang Anda masukkan tidak terdaftar.');
            }
        } else {
            // Validasi gagal
            return redirect()->to('/')->withInput()->with('errors', $validation->getErrors());
        }
    }

    // Metode logout
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
