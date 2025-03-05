<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\DosenModel;

class Dosen extends BaseController
{
    use ResponseTrait;
    private $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $data = $this->dosenModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($nidn)
    {
        $data = $this->dosenModel->where('nidn', $nidn)->first();

        if (!$data) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        return $this->respond($data, 200);
    }


    public function create()
    {
        $dosenModel = new DosenModel();
        $nidn = $this->request->getPost('nidn');

        if ($dosenModel->find($nidn)) {
            return $this->fail('NIDN sudah terdaftar', 400);
        }

        $data = [
            'nidn' => $nidn,
            'nama_dosen' => $this->request->getPost('nama_dosen'),
            'jurusan' => $this->request->getPost('jurusan'),
            'email' => $this->request->getPost('email')
        ];

        $nidn = $dosenModel->insert($data);
        if (!$dosenModel->save($data)) {
            return $this->fail([
                'status' => 200,
                'message' => 'Data dosen berhasil ditambahkan',
                'errors' => $dosenModel->errors()
            ]);
        } else {
            return $this->respondCreated([
                'status' => 200,
                'message' => 'Data dosen berhasil ditambahkan',
                'data' => $data
            ]);
        }
    }


    public function update($nidn)
    {
        $dosenLama = $this->dosenModel->where('nidn', $nidn)->first();
        if (!$dosenLama) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        $input = $this->request->getRawInput();

        if (isset($input['nidn']) && $input['nidn'] !== $nidn) {
            if ($this->dosenModel->where('nidn', $input['nidn'])->first()) {
                return $this->fail('NIDN baru sudah digunakan', 400);
            }
        }

        $this->dosenModel->where('nidn', $nidn)->set($input)->update();

        return $this->respond([
            'status' => 200,
            'message' => 'Data dosen berhasil diperbarui',
            'data' => $input
        ]);
    }


    public function delete($nidn)
    {
        if ($this->dosenModel->where('nidn', $nidn)->first()) {
            $this->dosenModel->where('nidn', $nidn)->delete();
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Data dosen berhasil dihapus'
            ]);
        } else {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }
    }
}
