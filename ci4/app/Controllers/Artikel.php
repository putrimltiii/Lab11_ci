<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    // Halaman Publik: Menampilkan daftar artikel untuk pengunjung
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->table('artikel')
                                 ->select('artikel.*, kategori.nama_kategori')
                                 ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                                 ->findAll();
                                 
        $data['title'] = 'Daftar Artikel';
        return view('artikel/index', $data);
    }

    // Halaman Admin: Menampilkan artikel dengan fitur AJAX Search & Pagination
   public function admin_index()
{
    $model = new \App\Models\ArtikelModel();
    $q = $this->request->getVar('q');

    $builder = $model->table('artikel')
                     ->select('artikel.*, kategori.nama_kategori')
                     ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');
    
    if ($q) $builder->like('artikel.judul', $q);
    $data['artikel'] = $builder->findAll();

    // JIKA AJAX: Kirim JSON saja, jangan render View
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    }

    // JIKA AKSES BIASA: Render View
    return view('artikel/admin_index', $data);
}

    // Menambah Artikel
    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        
        if ($validation->withRequest($this->request)->run()) {
            $file = $this->request->getFile('gambar');
            $nama_file = ($file->isValid() && !$file->hasMoved()) ? $file->getRandomName() : null;
            if ($nama_file) $file->move(ROOTPATH . 'public/gambar', $nama_file);

            (new ArtikelModel())->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'), '-', true),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $nama_file,
            ]);
            return redirect()->to('/admin/artikel');
        }
        $data['kategori'] = (new KategoriModel())->findAll();
        $data['title'] = "Tambah Artikel";
        return view('artikel/form_add', $data);
    }

    // Mengedit Artikel
    public function edit($id)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->find($id);
        
        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('gambar');
            $namaGambar = $data['artikel']['gambar'];
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $namaGambar = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $namaGambar);
            }
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $namaGambar,
            ]);
            return redirect()->to('/admin/artikel');
        }
        $data['kategori'] = (new KategoriModel())->findAll();
        $data['title'] = 'Edit Artikel';
        return view('artikel/form_edit', $data);
    }

    // Menghapus Artikel
    public function delete($id)
    {
        (new ArtikelModel())->delete($id);
        return redirect()->to('/admin/artikel');
    }

    // Menampilkan detail artikel
    public function view($slug)
    {
        $data['artikel'] = (new ArtikelModel())->table('artikel')
                                              ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                                              ->where('slug', $slug)->first();
        if (!$data['artikel']) throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }
}