<?php

namespace App\Models;

use CodeIgniter\Model;

class TataTertibModel extends Model
{
    protected $table      = 'tata_tertib';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'kategori', 'keterangan', 'type', 'poin', 'createdAt', 'updatedAt'];
}
