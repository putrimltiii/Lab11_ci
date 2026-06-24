<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="<?= base_url('admin/artikel/edit/' . $artikel['id']); ?>" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?= $artikel['id']; ?>">
    
    <div class="form-group mb-3">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" value="<?= esc($artikel['judul']); ?>" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="isi">Isi Artikel</label>
        <textarea name="isi" id="isi" cols="50" rows="10" class="form-control" required><?= esc($artikel['isi']); ?></textarea>
    </div>

    <div class="form-group mb-3">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>" 
                    <?= ($artikel['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>>
                    <?= esc($k['nama_kategori']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group mb-3">
        <label>Gambar Saat Ini</label><br>
        <?php if (!empty($artikel['gambar'])): ?>
            <img src="<?= base_url('gambar/' . $artikel['gambar']); ?>" class="img-thumbnail mb-2" style="max-width: 200px;">
        <?php else: ?>
            <p class="text-muted"><em>Tidak ada gambar.</em></p>
        <?php endif; ?>
        
        <br>
        <label for="gambar">Ganti Gambar (Opsional)</label>
        <input type="file" name="gambar" id="gambar" class="form-control-file">
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
    </div>
</form> 

<?= $this->include('template/admin_footer'); ?>