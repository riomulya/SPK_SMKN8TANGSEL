<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'email';
    protected $allowedFields = ['email', 'password', 'createdAt', 'updatedAt', 'role'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required'
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'Email is required',
            // 'valid_email' => 'Please provide a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'password' => [
            'required' => 'Password is required'
        ]
    ];

    protected $skipValidation = false;
}
