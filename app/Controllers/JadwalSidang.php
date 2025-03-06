<?php 

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\JadwalSidangModel;

class JadwalSidang extends BaseController
{
    use ResponseTrait;
    private $jadwalSidangModel;

    public function __construct()
    {
        $this->jadwalSidangModel = new JadwalSidangModel();
    }

    public function index()
    {
        $data = $this->jadwalSidangModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id_jadwal)
    {
        $data = $this->jadwalSidangModel->find($id_jadwal);

        if (!$data) {
            return $this->failNotFound('Data jadwal sidang tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function create()
    {
        $data = [
            'waktu_sidang' => $this->request->getPost('waktu_sidang')
        ];

        if ($this->jadwalSidangModel->insert($data)) {
            return $this->respondCreated([
                'status' => 200,
                'message' => 'Jadwal sidang berhasil ditambahkan',
                'data' => $data
            ]);
        } else {
            return $this->fail('Gagal menambahkan jadwal sidang', 400);
        }
    }

    public function update($id_jadwal)
    {
        $jadwalLama = $this->jadwalSidangModel->find($id_jadwal);
        if (!$jadwalLama) {
            return $this->failNotFound('Data jadwal tidak ditemukan');
        }

        $input = $this->request->getRawInput();

        $data = [
            'waktu_sidang' => $input['waktu_sidang'] ?? $jadwalLama['waktu_sidang']
        ];

        if ($this->jadwalSidangModel->update($id_jadwal, $data)) {
            return $this->respond([
                'status' => 200,
                'message' => 'Jadwal sidang berhasil diperbarui',
                'data' => $data
            ]);
        } else {
            return $this->fail('Gagal memperbarui jadwal sidang', 400);
        }
    }

    public function delete($id_jadwal)
    {
        if ($this->jadwalSidangModel->find($id_jadwal)) {
            $this->jadwalSidangModel->delete($id_jadwal);
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Jadwal sidang berhasil dihapus'
            ]);
        } else {
            return $this->failNotFound('Data jadwal sidang tidak ditemukan');
        }
    }
}
?>