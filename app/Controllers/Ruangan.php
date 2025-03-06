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

    public function show($id_ruangan)
    {
        $data = $this->ruanganModel->where('id_ruangan', $id_ruangan)->first();

        if (!$data) {
            return $this->failNotFound('Data ruangan tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function create()
    {
        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'lokasi' => $this->request->getPost('lokasi')
        ];

        if ($this->ruanganModel->insert($data)) {
            return $this->respondCreated([
                'status' => 200,
                'message' => 'Data ruangan berhasil ditambahkan',
                'data' => $data
            ]);
        } else {
            return $this->fail('Gagal menambahkan data ruangan', 400);
        }
    }

    public function update($id_ruangan)
    {
        $ruanganLama = $this->ruanganModel->find($id_ruangan);
        if (!$ruanganLama) {
            return $this->failNotFound('Data ruangan tidak ditemukan');
        }

        $input = $this->request->getRawInput();

        $data = [
            'nama_ruangan' => $input['nama_ruangan'] ?? $ruanganLama['nama_ruangan'],
            'lokasi' => $input['lokasi'] ?? $ruanganLama['lokasi']
        ];

        if ($this->ruanganModel->update($id_ruangan, $data)) {
            return $this->respond([
                'status' => 200,
                'message' => 'Data ruangan berhasil diperbarui',
                'data' => $data
            ]);
        } else {
            return $this->fail('Gagal memperbarui data ruangan', 400);
        }
    }

    public function delete($id_ruangan)
    {
        if ($this->ruanganModel->find($id_ruangan)) {
            $this->ruanganModel->delete($id_ruangan);
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Data ruangan berhasil dihapus'
            ]);
        } else {
            return $this->failNotFound('Data ruangan tidak ditemukan');
        }
    }
}
