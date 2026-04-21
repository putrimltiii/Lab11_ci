<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home', [
            'title'   => 'Halaman Home',
            'content' => 'Selamat datang di Portal Berita. Website ini dibuat menggunakan Framework CodeIgniter 4.',
        ]);
    }
}