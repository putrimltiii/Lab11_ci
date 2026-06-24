<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function create()
    {
        $model = new ArtikelModel();
        $json = $this->request->getJSON(true);
        $data = [
            'judul'  => $json['judul']  ?? $this->request->getVar('judul'),
            'isi'    => $json['isi']    ?? $this->request->getVar('isi'),
            'status' => $json['status'] ?? $this->request->getVar('status') ?? 0,
        ];
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => ['success' => 'Data artikel berhasil ditambahkan.']
        ];
        return $this->respondCreated($response);
    }

    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    public function update($id = null)
    {
        $model = new ArtikelModel();
        $json = $this->request->getJSON(true);
        $data = [
            'judul'  => $json['judul']  ?? null,
            'isi'    => $json['isi']    ?? null,
            'status' => $json['status'] ?? null,
        ];
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => ['success' => 'Data artikel berhasil diubah.']
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => ['success' => 'Data artikel berhasil dihapus.']
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}