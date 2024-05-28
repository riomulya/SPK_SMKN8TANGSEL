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
        'diakui', 'pelapor', "deskripsi", 'updatedAt', 'createdAt'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $dateFormat    = 'datetime';

    protected $validationRules    = [
        'id_pengakuan' => 'required',
        'pelaku'       => 'required',
        'kategori'     => 'required',
        'keterangan'   => 'required|string|max_length[255]',
        'poin'         => 'required|integer',
        'diakui'       => 'required|in_list[pending,tolak,terima]',
        'pelapor'      => 'required',
        'deskripsi'    => 'permit_empty',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
