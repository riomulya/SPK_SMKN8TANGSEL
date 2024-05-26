<?php

namespace App\Models;

use CodeIgniter\Model;

class TataTertibModel extends Model
{
    protected $table      = 'tata_tertib';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'kategori', 'keterangan', 'type', 'poin', 'createdAt', 'updatedAt'];

    // Method to get rewards
    public function getRewards()
    {
        return $this->where('type', 'penghargaan')->findAll();
    }

    // Method to get violations
    public function getViolations()
    {
        return $this->where('type', 'pelanggaran')->findAll();
    }


    public function search($keyword)
    {
        return $this->table('tata_tertib')->like('kategori', $keyword)->orLike('keterangan', $keyword)->orLike('type', $keyword);
    }

    public function searchSiswa($keyword)
    {
        return $this->table('siswa')->like('nama', $keyword)->orLike('nisn', $keyword)->orLike('email', $keyword)->orLike('kelas', $keyword);
    }
}
