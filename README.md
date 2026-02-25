# Lab11_ci

# Pemrograman Web 2

# Nama: Putri Melati Ramadhaniati
# NIM: 312410194
# Kelas: I241B
## PERTEMUAN 2

# Praktikum ini bertujuan untuk memahami konsep Model-View-Controller (MVC) menggunakan framework CodeIgniter 4. Implementasi dilakukan dengan membuat routing, controller, dan view untuk beberapa halaman seperti Home, About, Contact, dan Artikel.

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/fe68fffc-204e-4a5d-b5c6-7d64d89cba30" />
## Pada tahap ini, CodeIgniter 4 berhasil diinstal dan dijalankan melalui browser dengan alamat http://localhost:8080/. Halaman default ini menandakan bahwa framework sudah berjalan dengan baik dan siap digunakan untuk pengembangan aplikasi.

---------------------

## Menambahkan routing untuk menghubungkan URL dengan controller Page. 
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/b104176d-e884-4e87-abb0-22d3f1da407c" />

---------------------

## Controller Page.php dibuat untuk menangani request dari user dan menghubungkan dengan view.
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/c44082d6-9b25-47cf-b260-3b284761cf85" />
- Penjelasan: Controller Page.php dibuat untuk menangani logika aplikasi. Controller ini berisi beberapa method seperti home(), about(), contact(), dan artikel(). Setiap method mengembalikan tampilan menggunakan fungsi return view(), yang mengirimkan data berupa title dan content ke file view. Ini menunjukkan penerapan arsitektur Model-View-Controller, di mana controller bertindak sebagai penghubung antara sistem dan tampilan.

---------------------

## About.php
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/5ee02733-4e6b-4d38-a020-93ceab2f21f9" />
- Penjelasan: about.php dibuat pada direktori app/Views. View berfungsi sebagai komponen yang menangani tampilan antarmuka pengguna. Menggunakan sintaks <?= $title ?> dan <?= $content ?> untuk menampilkan data yang dikirim dari controller. Hal ini menunjukkan bahwa data telah berhasil diteruskan dari controller ke view.
  
--------------------

## Artikel.php
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/1ee0777f-9586-4719-b2f8-edcbe0d99687" />
- Penjelasan: artikel.php dibuat untuk menampilkan halaman artikel. Sama seperti halaman About, file ini menerima data dari controller dan menampilkannya dalam format HTML. Pembuatan file ini bertujuan untuk memastikan setiap halaman memiliki view terpisah sehingga struktur kode menjadi lebih terorganisir dan modular.

--------------------

## Contact.php
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/5850c7c5-4edb-44a8-a1ac-637d823c6527" />

--------------------

## Home.php
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/248c848a-2b30-4f2c-b60a-d2bdad7f6990" />

--------------------

## Header.php
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/48bd87b8-28f4-46a3-85ef-73a1e17e42bb" />

--------------------

## Footer.php
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/4ddc4c52-c66e-4914-89fd-19fca63bd5a0" />

-------------------

## Style.css
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/60416999-c5b5-43d5-986e-768a5eefe2cc" />

------------------

## Ini halaman Public: http://localhost/lab11_ci/ci4/public/
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/7facd40f-38fe-4bde-bfe0-32c50ec6ac07" />

--------------------

## Tampilan error page
<img width="1618" height="869" alt="image" src="https://github.com/user-attachments/assets/e80c6a87-5106-4cf1-b918-d81c041d1d4e" />

---------------------

## ini Halaman About: http://localhost:8080/about
<img width="1633" height="872" alt="image" src="https://github.com/user-attachments/assets/0806e710-9cc0-4b25-93bc-a2848af0fd26" />

## Setelah ditambahkan Style.css praktikum lab4_layout
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/797690e4-45b5-4bdc-9f61-139bc419f361" />
- Penjelasan: Halaman About berhasil ditampilkan melalui URL /about. Tampilan menunjukkan bahwa routing, controller, dan view telah terintegrasi dengan baik. Data yang dikirim dari controller berhasil ditampilkan pada browser, menandakan implementasi MVC berjalan sesuai prosedur.

--------------------

## Ini Halaman Contact: http://localhost:8080/contact
<img width="1920" height="961" alt="halaman contact" src="https://github.com/user-attachments/assets/d661a17a-8af0-4892-aa45-11f740934058" />

## Setelah ditambahkan Style.css praktikum lab4_layout
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/3af57913-87ca-4c1a-8283-f356f79380cf" />

-------------------

## Ini Halaman Artikel: http://localhost:8080/artikel
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/2681f059-e2dc-4839-b6c1-b5ea2374bc92" />
- Penjelasan: Halaman Artikel berhasil ditampilkan melalui URL /artikel. Hal ini membuktikan bahwa method artikel() pada controller telah berfungsi dengan baik serta file view sudah tersedia pada direktori yang benar.

# Kesimpulan: 
Praktikum ini berhasil mengimplementasikan konsep MVC pada framework CodeIgniter. Routing digunakan untuk mengatur jalur URL, controller menangani logika aplikasi, dan view bertanggung jawab terhadap tampilan.
Hasil akhir menunjukkan bahwa setiap halaman dapat diakses dengan URL yang berbeda dan menampilkan konten sesuai dengan method yang dibuat pada controller.









