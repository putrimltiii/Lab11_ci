# Lab11_CI - Pemrograman Web 2

**Nama:** Putri Melati Ramadhaniati  
**NIM:** (isi NIM kamu)  
**Kelas:** (isi kelas kamu)  
**Dosen:** Agung Nugroho  
**Mata Kuliah:** Pemrograman Web 2 — Universitas Pelita Bangsa  

---

Repository ini berisi laporan praktikum Pemrograman Web 2. Semua praktikum dikerjakan menggunakan Framework CodeIgniter 4 dan disusun secara berurutan dari Praktikum 1 sampai 10.

---

## Praktikum 1 - Pengenalan CodeIgniter 4

Praktikum pertama ini tujuannya buat kenalan dulu sama CodeIgniter 4 — mulai dari instalasi, struktur foldernya, sampai bikin halaman sederhana pakai konsep MVC.

### Persiapan Awal

Sebelum mulai, ada beberapa ekstensi PHP yang perlu diaktifkan dulu lewat XAMPP. Caranya buka XAMPP Control Panel → Apache → Config → PHP.ini, lalu cari bagian extension dan hapus tanda titik koma (`;`) di depan ekstensi berikut:

- `php-json`
- `php-mysqlnd`
- `php-xml`
- `php-intl`

Setelah disimpan, restart Apache-nya.

### Instalasi CodeIgniter 4

Download CI4 dari https://codeigniter.com/download, ekstrak ke folder `htdocs/lab11_ci`, rename foldernya jadi `ci4`, lalu buka di browser:

```
http://localhost/lab11_ci/ci4/public/
```

![Tampilan Awal CI4](screenshot/p1_tampilan_ci4.png)

### Menjalankan CLI

Buka terminal, arahkan ke folder project, lalu ketik:

```bash
php spark
```

![Tampilan CLI](screenshot/p1_cli.png)

### Aktifkan Mode Debugging

Rename file `env` jadi `.env`, buka filenya, lalu ubah baris ini:

```
CI_ENVIRONMENT = development
```

Ini berguna biar error yang muncul lebih jelas dan mudah dilacak.

### Membuat Route dan Controller

Tambahkan route baru di `app/Config/Routes.php`:

```php
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
```

Kalau langsung diakses tanpa controller, akan muncul error 404 dulu.

![Error 404](screenshot/p1_error404.png)

Buat controller-nya di `app/Controllers/Page.php`:

```php
<?php
namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        echo "Ini halaman About";
    }

    public function contact()
    {
        echo "Ini halaman Contact";
    }

    public function faqs()
    {
        echo "Ini halaman FAQ";
    }
}
```

### Membuat View dengan Layout

Buat file `app/Views/template/header.php` dan `footer.php` sebagai template. Lalu buat `app/Views/about.php`:

```php
<?= $this->include('template/header'); ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->include('template/footer'); ?>
```

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/e1041fe4-273b-4c13-ae12-67963a19c527" />


---

## Praktikum 2 - CRUD Artikel

Di praktikum ini mulai bikin aplikasi CRUD sederhana untuk data artikel, lengkap dengan database MySQL.

### Buat Database dan Tabel

```sql
CREATE DATABASE lab_ci4;

CREATE TABLE artikel (
    id INT(11) auto_increment,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    PRIMARY KEY(id)
);
```

### Konfigurasi Koneksi Database

Di file `.env`, sesuaikan bagian ini:

```
database.default.hostname = localhost
database.default.database = lab_ci4
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

### Membuat Model

Buat `app/Models/ArtikelModel.php`:

```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar'];
}
```

### Membuat Controller

Buat `app/Controllers/Artikel.php` dengan method:
- `index()` — tampilkan daftar artikel
- `view($slug)` — tampilkan detail artikel
- `admin_index()` — halaman admin
- `add()` — tambah artikel
- `edit($id)` — edit artikel
- `delete($id)` — hapus artikel

### Hasil

Pertama kali diakses, tabel masih kosong.

Setelah data dimasukkan via SQL:

```sql
INSERT INTO artikel (judul, isi, slug) VALUES
('Artikel pertama', 'Lorem Ipsum...', 'artikel-pertama'),
('Artikel kedua', 'Tidak seperti...', 'artikel-kedua');
```

<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/96ce23ab-fa4b-4ce4-8a00-890bbe04df59" />


<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/ba54642a-01ec-4d64-9359-fafade90bfc1" />

<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/694ac1da-6b66-46de-865c-2735851ae29f" />


![Form Tambah](screenshot/p2_form_tambah.png)

![Form Edit](screenshot/p2_form_edit.png)

---

## Praktikum 3 - View Layout dan View Cell

Kalau sebelumnya pakai `include` buat template, sekarang pakai cara yang lebih rapi yaitu View Layout dan View Cell.

### Membuat Layout Utama

Buat folder `app/Views/layout/` dan file `main.php`. Di dalamnya ada bagian yang bisa diisi konten dari view lain:

```php
<?= $this->renderSection('content') ?>
```

### Modifikasi View yang Ada

Setiap view sekarang cukup extend layout utama:

```php
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
    <h1><?= $title; ?></h1>
    <p><?= $content; ?></p>
<?= $this->endSection() ?>
```

### Membuat View Cell

View Cell dipakai buat komponen yang muncul berulang — misalnya widget artikel terkini di sidebar.

Buat `app/Cells/ArtikelTerkini.php`:

```php
<?php
namespace App\Cells;
use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini extends Cell
{
    public function render()
    {
        $model = new ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}
```

Lalu buat viewnya di `app/Views/components/artikel_terkini.php`.

![Layout Baru](screenshot/p3_layout_baru.png)

![Sidebar View Cell](screenshot/p3_view_cell.png)

---

## Praktikum 4 - Modul Login

Praktikum ini bikin fitur login lengkap dengan filter — jadi halaman admin tidak bisa diakses kalau belum login.

### Buat Tabel User

```sql
CREATE TABLE user (
    id INT(11) auto_increment,
    username VARCHAR(200) NOT NULL,
    useremail VARCHAR(200),
    userpassword VARCHAR(200),
    PRIMARY KEY(id)
);
```

### Model dan Controller

Buat `app/Models/UserModel.php` dan `app/Controllers/User.php`. Di controller, method `login()` pakai `password_verify()` untuk cek password, dan session disimpan kalau login berhasil.

### View Login

Buat `app/Views/user/login.php` dengan form yang menerima email dan password.

<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/a370b060-7b54-4848-8dd4-c3f79693fbb0" />


### Database Seeder

Buat data user awal lewat seeder:

```bash
php spark make:seeder UserSeeder
php spark db:seed UserSeeder
```

Login default: email `admin@email.com`, password `admin123`.

### Auth Filter

Buat `app/Filters/Auth.php` — fungsinya redirect ke halaman login kalau session belum ada:

```php
if (!session()->get('logged_in')) {
    return redirect()->to('/user/login');
}
```

Daftarkan di `app/Config/Filters.php`:

```php
'auth' => App\Filters\Auth::class
```

![Redirect ke Login](screenshot/p4_redirect_login.png)

<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/64422a61-e48a-4f18-8ddd-f50f12598eeb" />


---

## Praktikum 5 - Pagination dan Pencarian

Kalau data artikel sudah banyak, perlu dipaginasi biar tidak tampil semua sekaligus. Di praktikum ini juga ditambah fitur pencarian.

### Pagination

Modifikasi method `admin_index()`:

```php
public function admin_index()
{
    $title = 'Daftar Artikel';
    $q = $this->request->getVar('q') ?? '';
    $model = new ArtikelModel();
    $data = [
        'title'   => $title,
        'q'       => $q,
        'artikel' => $model->like('judul', $q)->paginate(10),
        'pager'   => $model->pager,
    ];
    return view('artikel/admin_index', $data);
}
```

Tambahkan di bagian bawah view:

```php
<?= $pager->only(['q'])->links(); ?>
```

![Tampilan Pagination](screenshot/p5_pagination.png)

### Form Pencarian

Tambahkan form di atas tabel:

```html
<form method="get" class="form-search">
    <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
    <input type="submit" value="Cari" class="btn btn-primary">
</form>
```

<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/ba1ebc75-11ef-4b06-bb7c-53c37068a22d" />


---

## Praktikum 6 - Relasi Tabel dan Query Builder

Di sini artikel dihubungkan ke tabel kategori, jadi setiap artikel punya kategori. Ini contoh relasi One-to-Many.

### Buat Tabel Kategori

```sql
CREATE TABLE kategori (
    id_kategori INT(11) AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    slug_kategori VARCHAR(100),
    PRIMARY KEY (id_kategori)
);
```

### Tambah Foreign Key ke Tabel Artikel

```sql
ALTER TABLE artikel
ADD COLUMN id_kategori INT(11),
ADD CONSTRAINT fk_kategori_artikel
FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori);
```

### Model Artikel — Method Join

Tambahkan method baru di `ArtikelModel.php`:

```php
public function getArtikelDenganKategori()
{
    return $this->db->table('artikel')
        ->select('artikel.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
        ->get()
        ->getResultArray();
}
```

### Update View

Semua view yang menampilkan artikel diupdate — form tambah dan edit sekarang ada dropdown untuk memilih kategori.

![Artikel dengan Kategori](screenshot/p6_artikel_kategori.png)

![Form Tambah dengan Kategori](screenshot/p6_form_tambah_kategori.png)

![Form Edit dengan Kategori](screenshot/p6_form_edit_kategori.png)

---

## Praktikum 7 - Upload Gambar

Fitur upload gambar ditambahkan ke form tambah artikel.

### Modifikasi Method `add()`

```php
$file = $this->request->getFile('gambar');
$file->move(ROOTPATH . 'public/gambar');
$artikel->insert([
    'judul'  => $this->request->getPost('judul'),
    'isi'    => $this->request->getPost('isi'),
    'slug'   => url_title($this->request->getPost('judul')),
    'gambar' => $file->getName(),
]);
```

### Modifikasi Form

Tambahkan input file dan ubah tag form-nya:

```html
<form action="" method="post" enctype="multipart/form-data">
    <p>
        <input type="file" name="gambar">
    </p>
</form>
```

![Form Upload](screenshot/p7_form_upload.png)

![Artikel dengan Gambar](screenshot/p7_artikel_gambar.png)

---

## Praktikum 8 - AJAX

AJAX (Asynchronous JavaScript and XML) memungkinkan halaman web mengambil data dari server tanpa harus reload seluruh halaman. Di praktikum ini AJAX dipakai untuk menampilkan dan menghapus data artikel.

### Cara Kerja Singkat

1. User klik tombol atau melakukan aksi
2. JavaScript kirim request ke server
3. Server proses dan balas dalam format JSON
4. JavaScript tampilkan hasilnya di halaman tanpa reload

### Persiapan

Download jQuery dari https://jquery.com, simpan di `public/assets/js/jquery-3.6.0.min.js`.

### AJAX Controller

Buat `app/Controllers/AjaxController.php`:

```php
public function getData()
{
    $model = new ArtikelModel();
    $data = $model->findAll();
    return $this->response->setJSON($data);
}

public function delete($id)
{
    $model = new ArtikelModel();
    $model->delete($id);
    return $this->response->setJSON(['status' => 'OK']);
}
```

### View dengan jQuery

Data dimuat lewat AJAX saat halaman pertama kali dibuka:

```javascript
$.ajax({
    url: "<?= base_url('ajax/getData') ?>",
    method: "GET",
    dataType: "json",
    success: function(data) {
        // render data ke tabel
    }
});
```

<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/b4d43e98-e597-484d-9188-2518fe71f7ae" />


![Hapus Data AJAX](screenshot/p8_ajax_hapus.png)

---

## Praktikum 9 - AJAX Pagination dan Search

Lanjutan dari praktikum sebelumnya — sekarang pagination dan pencarian juga pakai AJAX, jadi tidak ada reload halaman sama sekali.

### Modifikasi Controller

Method `admin_index()` diupdate agar bisa mendeteksi request AJAX:

```php
if ($this->request->isAJAX()) {
    return $this->response->setJSON($data);
} else {
    return view('artikel/admin_index', $data);
}
```

### jQuery di View

Semua interaksi — search, filter kategori, pindah halaman — dikirim lewat AJAX:

```javascript
const fetchData = (url) => {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(data) {
            renderArticles(data.artikel);
            renderPagination(data.pager, data.q, data.kategori_id);
        }
    });
};
```

Pagination dirender dinamis lewat JavaScript, tidak lagi dari PHP.

<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/cef5056c-caf4-4464-b85e-722406ba015c" />


<img width="1456" height="819" alt="image" src="https://github.com/user-attachments/assets/da5e3894-9b67-40fc-9bbf-7890e8c0f807" />


---

## Praktikum 10 - REST API

Praktikum terakhir ini bikin REST API menggunakan CodeIgniter 4. API ini bisa diakses dari aplikasi lain, misalnya frontend Vue.js atau aplikasi mobile.

### Apa itu REST API?

REST API adalah cara menghubungkan dua aplikasi lewat HTTP. Ibarat daftar menu di restoran — client hanya bisa request sesuai endpoint yang tersedia, dan server akan balas dengan data JSON.

### Instalasi Postman

Download Postman dari https://www.postman.com/downloads/ untuk keperluan testing API.

### Membuat REST Controller

Buat `app/Controllers/Post.php`:

```php
<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // GET semua data
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    // POST tambah data
    public function create()
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];
        $model->insert($data);
        return $this->respondCreated(['messages' => ['success' => 'Data berhasil ditambahkan.']]);
    }

    // GET data spesifik
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data tidak ditemukan.');
    }

    // PUT ubah data
    public function update($id = null)
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];
        $model->update($id, $data);
        return $this->respond(['messages' => ['success' => 'Data berhasil diubah.']]);
    }

    // DELETE hapus data
    public function delete($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            return $this->respondDeleted(['messages' => ['success' => 'Data berhasil dihapus.']]);
        }
        return $this->failNotFound('Data tidak ditemukan.');
    }
}
```

### Tambah Route

```php
$routes->resource('post');
```

Cek semua endpoint yang terbuat:

```bash
php spark routes
```

### Testing di Postman

**GET — Semua Data**  
Method: GET | URL: `http://localhost:8080/post`

![GET Semua Data](screenshot/p10_get_all.png)

**GET — Data Spesifik**  
Method: GET | URL: `http://localhost:8080/post/2`

![GET Spesifik](screenshot/p10_get_one.png)

**POST — Tambah Data**  
Method: POST | URL: `http://localhost:8080/post`  
Body: x-www-form-urlencoded → isi judul dan isi

![POST Tambah](screenshot/p10_post.png)

**PUT — Ubah Data**  
Method: PUT | URL: `http://localhost:8080/post/2`  
Body: x-www-form-urlencoded → isi data yang diubah

![PUT Ubah](screenshot/p10_put.png)

**DELETE — Hapus Data**  
Method: DELETE | URL: `http://localhost:8080/post/7`

![DELETE Hapus](screenshot/p10_delete.png)

---

## Struktur Folder Project

```
lab11_ci/
├── app/
│   ├── Cells/
│   │   └── ArtikelTerkini.php
│   ├── Config/
│   │   ├── Filters.php
│   │   └── Routes.php
│   ├── Controllers/
│   │   ├── Artikel.php
│   │   ├── AjaxController.php
│   │   ├── Post.php
│   │   └── User.php
│   ├── Filters/
│   │   └── Auth.php
│   ├── Models/
│   │   ├── ArtikelModel.php
│   │   ├── KategoriModel.php
│   │   └── UserModel.php
│   └── Views/
│       ├── artikel/
│       ├── components/
│       ├── layout/
│       ├── template/
│       └── user/
└── public/
    ├── assets/js/
    ├── gambar/
    └── style.css
```

---

*Putri Melati Ramadhaniati — Universitas Pelita Bangsa 2026*
