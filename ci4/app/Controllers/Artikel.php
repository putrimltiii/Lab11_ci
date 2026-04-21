<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title   = 'Daftar Artikel';
        $model   = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->findAll();

        return view('artikel/index', compact('artikel', 'title'));
    }

    public function view($slug)
    {
        $model   = new ArtikelModel();
        $artikel = $model->where(['slug' => $slug])->first();

        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];

        return view('artikel/detail', compact('artikel', 'title'));
    }

    // --- REVISI PRAKTIKUM 5: Pagination & Pencarian ---
    public function admin_index()
    {
        $title = 'Daftar Artikel';
        // Mengambil query pencarian 'q' dari request 
        $q = $this->request->getVar('q') ?? '';
        $model = new ArtikelModel();

        $data = [
            'title' => $title,
            'q' => $q,
            // Melakukan pencarian berdasarkan judul dan membatasi 10 data per halaman [cite: 84, 85]
            'artikel' => $model->like('judul', $q)->paginate(10),
            // Mengirim objek pager ke view [cite: 86]
            'pager' => $model->pager,
        ];

        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            $artikel = new ArtikelModel();
            $artikel->insert([
                'judul'      => $this->request->getPost('judul'),
                'isi'        => $this->request->getPost('isi'),
                'slug'       => url_title($this->request->getPost('judul')),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect('admin/artikel');
        }

        $title = "Tambah Artikel";
        return view('artikel/form_add', compact('title'));
    }

    public function edit($id)
    {
        $artikel    = new ArtikelModel();
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            $artikel->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi'   => $this->request->getPost('isi'),
            ]);
            return redirect('admin/artikel');
        }

        $data  = $artikel->where('id', $id)->first();
        $title = "Edit Artikel";
        return view('artikel/form_edit', compact('title', 'data'));
    }

    public function delete($id)
    {
        $artikel = new ArtikelModel();
        $artikel->delete($id);
        return redirect('admin/artikel');
    }
}