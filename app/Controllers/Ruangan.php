<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    use ResponseTrait;
    private $ruanganModel;

    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data = $this->ruanganModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($kode_ruangan)
    {
        $data = $this->ruanganModel->where('kode_ruangan', $kode_ruangan)->first();

        if (!$data) {
            return $this->failNotFound('Data ruangan tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function create()
    {
        $ruanganModel = new RuanganModel();
        
        $kode_ruangan = $this->request->getPost('kode_ruangan');

        $data = [
            'kode_ruangan' => $kode_ruangan,
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
        ];

        $kode_ruangan = $ruanganModel->insert($data);
        if (!$ruanganModel->save($data)) {
            return $this->fail([
                'status' => 400,
                'message' => 'Gagal menambahkan data ruangan',
                'errors' => $ruanganModel->errors()
            ]);
        }
        return $this->respondCreated([
            'status' => 200,
            'message' => 'Data ruangan berhasil ditambahkan',
            'data' => $data
        ]);
    }

    public function delete($kode_ruangan)
    {
        if ($this->ruanganModel->find($kode_ruangan)) {
            $this->ruanganModel->delete($kode_ruangan);
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Data ruangan berhasil dihapus'
            ]);
        } else {
            return $this->failNotFound('Data ruangan tidak ditemukan');
        }
    }
}
