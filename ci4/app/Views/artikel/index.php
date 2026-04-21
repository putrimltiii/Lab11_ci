<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h1><?= $title; ?></h1>
<hr>

<?php if ($artikel): foreach ($artikel as $row): ?>
<article class="entry">
    <h2>
        <a href="<?= base_url('/artikel/' . $row['slug']); ?>">
            <?= $row['judul']; ?>
        </a>
    </h2>
    <?php if (!empty($row['gambar'])): ?>
    <img src="<?= base_url('/gambar/' . $row['gambar']); ?>"
         alt="<?= $row['judul']; ?>">
    <?php endif; ?>
    <p><?= substr(strip_tags($row['isi']), 0, 200); ?></p>
    <small style="color:#999;">
        <?= date('d M Y', strtotime($row['created_at'])) ?>
    </small>
</article>
<hr class="divider">
<?php endforeach; else: ?>
<article class="entry">
    <h2>Belum ada data.</h2>
</article>
<?php endif; ?>

<?= $this->endSection() ?>