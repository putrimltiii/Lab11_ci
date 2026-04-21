<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title'   => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title'   => 'Halaman Kontak',
            'content' => 'Ini adalah halaman kontak. Silakan hubungi kami melalui email atau telepon.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title'   => 'Halaman FAQ',
            'content' => 'Ini adalah halaman FAQ yang berisi pertanyaan yang sering ditanyakan.'
        ]);
    }

    public function tos()
    {
        return view('tos', [
            'title'   => 'Term of Services',
            'content' => 'Ini adalah halaman Term of Services.'
        ]);
    }
}