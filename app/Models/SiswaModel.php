<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'nisn';
    protected $allowedFields = ['nisn', 'email', 'nama', 'tanggal_lahir', 'jenis_kelamin', 'kelas', 'poin', 'createdAt', 'updatedAt'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $validationRules = [
        'nisn' => 'required|is_unique[siswa.nisn]',
        'email' => 'required|valid_email',
        'nama' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'kelas' => 'required'
    ];

    protected $validationMessages = [
        'nisn' => [
            'required' => 'NISN is required',
            'is_unique' => 'This NISN is already registered'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please provide a valid email address'
        ],
        'nama' => [
            'required' => 'Name is required'
        ],
        'tanggal_lahir' => [
            'required' => 'Date of birth is required'
        ],
        'jenis_kelamin' => [
            'required' => 'Gender is required'
        ],
        'kelas' => [
            'required' => 'Class is required'
        ]
    ];

    protected $skipValidation = false;

    public function search($keyword)
    {
        return $this->table('siswa')->like('nama', $keyword)->orLike('nisn', $keyword)->orLike('email', $keyword)->orLike('kelas', $keyword);
    }
}
