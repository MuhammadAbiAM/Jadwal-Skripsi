<?php 

namespace App\Models;
use CodeIgniter\Model;

class JadwalSidangModel extends Model {
    protected $table = 'jadwal_sidang';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = [
        'waktu_sidang'
    ];
}
?>