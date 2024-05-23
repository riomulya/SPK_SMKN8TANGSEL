<?php

namespace App\Models;

use CodeIgniter\Model;

class PengakuanModel extends Model
{
    protected $table      = 'pengakuan';
    protected $primaryKey = 'id_pengakuan';
    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_pengakuan', 'pelaku', 'kategori', 'keterangan', 'poin',
        'diakui', 'pelapor', 'updatedAt', 'createdAt'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $dateFormat    = 'datetime';

    protected $validationRules    = [
        'id_pengakuan' => 'required|alpha_numeric|min_length[3]|max_length[255]',
        'pelaku'       => 'permit_empty|alpha_numeric_space|max_length[255]',
        'kategori'     => 'required|alpha_numeric_space|max_length[255]',
        'keterangan'   => 'permit_empty|string|max_length[255]',
        'poin'         => 'required|integer',
        'diakui'       => 'required|in_list[pending,tolak,terima]',
        'pelapor'      => 'required|alpha_numeric_space|max_length[255]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
