<?php 
namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model {
    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    protected $allowedFields = [
        'npm',
        'nama_mahasiswa', 
        'jurusan', 
        'program_studi', 
        'judul_skripsi', 
        'email'
    ];
}
?>