<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table = 'Guru';
    protected $primaryKey = 'nip';
    protected $allowedFields = [
        'nip',
        'email',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'kelas_mengajar',
        'createdAt',
        'updatedAt'
    ];


    public function search($keyword)
    {
        return $this->table('guru')->like('nama', $keyword)->orLike('nip', $keyword)->orLike('email', $keyword)->orLike('kelas_mengajar', $keyword);
    }
}
