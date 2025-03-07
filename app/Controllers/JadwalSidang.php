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
        $jadwalSidangModel = new JadwalSidangModel();

        $npm = $this->request->getPost('npm');
        $kode_ruangan = $this->request->getPost('kode_ruangan');
        $waktu_sidang = $this->request->getPost('waktu_sidang');

        if ($jadwalSidangModel->where('npm', $npm)->countAllResults() > 0) {
            return $this->fail([
                'status' => 400,
                'message' => 'Mahasiswa dengan NPM ini sudah memiliki jadwal sidang'
            ]);
        }

        $data = [
            'npm' => $npm,
            'kode_ruangan' => $kode_ruangan,
            'waktu_sidang' => $waktu_sidang
        ];

        if (!$jadwalSidangModel->insert($data)) {
            return $this->fail([
                'status' => 400,
                'message' => 'Gagal menambahkan data jadwal sidang',
                'errors' => $jadwalSidangModel->errors()
            ]);
        }

        return $this->respondCreated([
            'status' => 200,
            'message' => 'Data jadwal sidang berhasil ditambahkan',
            'data' => $data
        ]);
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
