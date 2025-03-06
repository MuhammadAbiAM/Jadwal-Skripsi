<?php

namespace App\Models;
use CodeIgniter\Model;

class RuanganModel extends Model {
    protected $table = 'ruangan';
    protected $primaryKey = 'kode_ruangan';
    protected $allowedFields = [
        'nama_ruangan',
    ];
}
?>