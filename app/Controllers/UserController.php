<?php

namespace App\Controllers;

use App\Models\UserModel;


class UserController extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function insert()
    {
        // Ambil data dari request
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Insert data ke dalam tabel 'users'
        $userData = [
            'email' => $email,
            // 'password' => password_hash($password, PASSWORD_DEFAULT),
            // tambahkan kolom lain sesuai kebutuhan
        ];
        try {
            $this->userModel->insert($userData);
            return redirect()->to('/dashboard')->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }
}
