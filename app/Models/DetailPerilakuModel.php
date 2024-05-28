<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPerilakuModel extends Model
{
    protected $table = 'detail_perilaku_siswa';
    protected $primaryKey = 'id_perilaku';
    protected $allowedFields = [
        'id_perilaku', 'nisn', 'id_pengakuan', 'updatedAt', 'createdAt'
    ];

    public function search($keyword)
    {
        return $this->table('detail_perilaku_siswa')->like('nisn', $keyword)->orLike('nisn', $keyword)->find();
    }
}
