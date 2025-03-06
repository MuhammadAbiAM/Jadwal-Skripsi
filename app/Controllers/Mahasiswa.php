<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;

class Mahasiswa extends BaseController
{
    use ResponseTrait;
    private $mahasiswaModel;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
    }

    public function index()
    {
        $data = $this->mahasiswaModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id)
    {
        $data = $this->mahasiswaModel->where('npm', $id)->first();

        if (!$data) {
            return $this->failNotFound('Data ruangan tidak ditemukan');
        }

        return $this->respond($data, 200);
    }


    public function create()
    {
        $mahasiswaModel = new MahasiswaModel();

        $npm = $this->request->getPost('npm');

        if ($mahasiswaModel->find($npm)) {
            return $this->fail('NPM sudah terdaftar', 400);
        }

        $data = [
            'npm' => $npm,
            'nama_mahasiswa' => $this->request->getPost('nama_mahasiswa'),
            'jurusan' => $this->request->getPost('jurusan'),
            'program_studi' => $this->request->getPost('program_studi'),
            'judul_skripsi' => $this->request->getPost('judul_skripsi'),
            'email' => $this->request->getPost('email')
        ];

        $npm = $mahasiswaModel->insert($data);
        if (!$mahasiswaModel->save($data)) {
            return $this->fail([
                'status' => 400,
                'message' => 'Gagal menambahkan data mahasiswa',
                'errors' => $mahasiswaModel->errors()
            ]);
        }

        return $this->respondCreated([
            'status' => 200,
            'message' => 'Data mahasiswa berhasil ditambahkan',
            'data' => $data
        ]);
    }

    public function update($npm)
    {
        $mahasiswaModel = new MahasiswaModel();

        $input = $this->request->getRawInput();

        $mahasiswaLama = $mahasiswaModel->where('npm', $npm)->first();
        if (!$mahasiswaLama) {
            return $this->failNotFound('Data mahasiswa tidak ditemukan');
        }

        if (isset($input['npm']) && $input['npm'] !== $npm) {
            if ($mahasiswaModel->where('npm', $input['npm'])->first()) {
                return $this->fail('NPM baru sudah digunakan', 400);
            }

            $db = \Config\Database::connect();
            $builder = $db->table('mahasiswa');
            $builder->where('npm', $npm);
            $builder->update(['npm' => $input['npm']]);

            $npm = $input['npm'];
        }

        $dataUpdate = [
            'npm' => $npm,
            'nama_mahasiswa' => $input['nama_mahasiswa'] ?? $mahasiswaLama['nama_mahasiswa'],
            'jurusan' => $input['jurusan'] ?? $mahasiswaLama['jurusan'],
            'program_studi' => $input['program_studi'] ?? $mahasiswaLama['program_studi'],
            'judul_skripsi' => $input['judul_skripsi'] ?? $mahasiswaLama['judul_skripsi'],
            'email' => $input['email'] ?? $mahasiswaLama['email']
        ];

        if ($mahasiswaModel->update($npm, $dataUpdate)) {
            return $this->respond([
                'status' => 200,
                'message' => 'Data mahasiswa berhasil diperbarui',
                'data' => $dataUpdate
            ]);
        } else {
            return $this->fail('Gagal memperbarui data mahasiswa', 400);
        }
    }

    public function delete($npm)
    {
        $mahasiswaModel = new MahasiswaModel();

        if ($mahasiswaModel->find($npm)) {
            $mahasiswaModel->delete($npm);
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Data mahasiswa berhasil dihapus'
            ]);
        } else {
            return $this->failNotFound('Data mahasiswa tidak ditemukan');
        }
    }
}
