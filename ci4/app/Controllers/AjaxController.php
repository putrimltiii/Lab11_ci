<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    // Menampilkan halaman utama tempat tabel AJAX berada
    public function index()
    {
        // Mengirim data title agar header tidak memicu error 'Undefined variable $title'
        $data = [
            'title' => 'Manajemen Artikel (AJAX)'
        ];
        return view('ajax/index', $data);
    }

    // Ambil seluruh data artikel (Format JSON) - READ
    public function getData()
    {
        $model = new ArtikelModel();
        $data = $model->findAll();
        
        return $this->response->setJSON($data);
    }

    // Ambil satu data detail berdasarkan ID untuk Form Edit (Format JSON)
    public function getById($id)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);
        
        return $this->response->setJSON($data);
    }

    // Simpan data artikel baru (Format JSON) - CREATE
    public function create()
    {
        $model = new ArtikelModel();
        
        $insertData = [
            'judul'  => $this->request->getPost('judul'),
            'isi'    => $this->request->getPost('isi'),
            'status' => $this->request->getPost('status')
        ];

        if ($model->insert($insertData)) {
            return $this->response->setJSON([
                'status'  => 'OK',
                'message' => 'Artikel baru berhasil disimpan!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'ERROR',
            'message' => 'Gagal menyimpan artikel.'
        ]);
    }

    // Update data artikel lama berdasarkan ID (Format JSON) - UPDATE
    public function update($id)
    {
        $model = new ArtikelModel();
        
        $updateData = [
            'judul'  => $this->request->getPost('judul'),
            'isi'    => $this->request->getPost('isi'),
            'status' => $this->request->getPost('status')
        ];

        if ($model->update($id, $updateData)) {
            return $this->response->setJSON([
                'status'  => 'OK',
                'message' => 'Artikel berhasil diperbarui!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'ERROR',
            'message' => 'Gagal memperbarui artikel.'
        ]);
    }

    // Hapus data artikel berdasarkan ID (Format JSON) - DELETE
    public function delete($id)
    {
        $model = new ArtikelModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status'  => 'OK',
                'message' => 'Artikel berhasil dihapus!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'ERROR',
            'message' => 'Gagal menghapus data artikel.'
        ]);
    }
}