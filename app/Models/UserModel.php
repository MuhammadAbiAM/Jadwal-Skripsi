<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $allowFields = ['loker_buku', 'no_rek', 'no_laci', 'no_boks', 'judul_buku', 'nama_pengarang', 'tahun_terbit', 'penerima', 'penerbit', 'status', 'keterangan'];

    public function getAllUser()
    {
        return $this->findAll();
    }
}
?>