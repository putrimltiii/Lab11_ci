<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<article class="entry">
    <h1><?= $artikel['judul']; ?></h1>
    <small style="color:#999;">
        <?= date('d M Y', strtotime($artikel['created_at'])) ?>
    </small>
    <hr>
    <?php if (!empty($artikel['gambar'])): ?>
    <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>"
         alt="<?= $artikel['judul']; ?>">
    <?php endif; ?>
    <p><?= $artikel['isi']; ?></p>
</article>

<a href="<?= base_url('/artikel'); ?>" class="btn btn-primary"
   style="display:inline-block; margin-top:15px;">
    ← Kembali
</a>

<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<article class="entry">
    <h1><?= $artikel['judul']; ?></h1>
    <small style="color:#999;">
        <?= date('d M Y', strtotime($artikel['created_at'])) ?> | 
        Kategori: <?= $artikel['nama_kategori'] ?> </small>
    <hr>
    <?php if (!empty($artikel['gambar'])): ?>
    <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>"
         alt="<?= $artikel['judul']; ?>">
    <?php endif; ?>
    <p><?= $artikel['isi']; ?></p>
</article>

<a href="<?= base_url('/artikel'); ?>" class="btn btn-primary"
   style="display:inline-block; margin-top:15px;">
   ← Kembali
   
</a>

<?= $this->endSection() ?>