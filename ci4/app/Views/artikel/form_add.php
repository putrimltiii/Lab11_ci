<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="<?= base_url('admin/artikel/add'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?> <p>
        <label for="judul">Judul</label><br>
        <input type="text" name="judul" id="judul" class="form-control" required>
    </p>

    <p>
        <label for="gambar">Gambar</label><br>
        <input type="file" name="gambar" id="gambar" class="form-control">
    </p>

    <p>
        <label for="isi">Isi</label><br>
        <textarea name="isi" id="isi" class="form-control" cols="50" rows="10"></textarea>
    </p>

    <p>
        <label for="id_kategori">Kategori</label><br>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p><input type="submit" value="Kirim" class="btn btn-primary btn-large"></p>
</form>

<?= $this->include('template/admin_footer'); ?>