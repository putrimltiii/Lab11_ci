<?= $this->include('template/header'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            
            <article class="entry">
                <h1 class="mb-3" style="font-weight: 700; color: #2c3e50;"><?= $artikel['judul']; ?></h1>
                
                <p class="text-muted small mb-4">
                    Dipublikasikan pada: <?= date('d M Y'); ?> | Kategori: <?= $artikel['kategori'] ?? 'Umum'; ?>
                </p>
                
                <?php if (!empty($artikel['gambar'])) : ?>
                    <div class="mb-4 text-center">
                        <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" 
                             alt="<?= $artikel['judul']; ?>" 
                             class="img-fluid rounded shadow-sm" 
                             style="width: 100%; max-height: 500px; object-fit: cover;">
                    </div>
                <?php endif; ?>
                
                <div class="entry-content" style="font-size: 1.1rem; line-height: 1.8; color: #333; text-align: justify;">
                    <?= nl2br($artikel['isi']); ?>
                </div>
            </article>

        </div>
    </div>
</div>

<?= $this->include('template/footer'); ?>