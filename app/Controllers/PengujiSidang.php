<?php 

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\PengujiSidangModel;

class PengujiSidang extends BaseController
{
    use ResponseTrait;
    private $pengujiSidangModel;

    public function __construct()
    {
        $this->pengujiSidangModel = new PengujiSidangModel();
    }

    public function index()
    {
        $data = $this->pengujiSidangModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id_penguji)
    {
        $data = $this->pengujiSidangModel->where('id_penguji', $id_penguji)->first();

        if (!$data) {
            return $this->failNotFound('Data penguji tidak ditemukan');
        }

        return $this->respond($data, 200);
    }
}
?>