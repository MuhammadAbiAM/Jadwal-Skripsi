<?php 
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UserApi extends BaseController{
    use ResponseTrait;

    public function index(){
        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8000');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type');

        $userModel = new UserModel();
        $buku = $userModel->findAll();

        if ($buku) {
            return $this->respond([
            'status' => 'Success',
            'message' => 'Data Berhasil Diambil',
            'data' => $buku
            ], 200);
        } else {
            return $this->respond([
                'status' => 'Error',
                'message' => 'Data Tidak Ditemukan',
                'data' => []
                ], 404);
        }   
    }
}
?>