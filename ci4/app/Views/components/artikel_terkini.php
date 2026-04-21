<div class="widget-box">
    <h3 class="title">Artikel Terkini</h3>
    <ul>
        <?php if (!empty($artikel)): ?>
            <?php foreach ($artikel as $row): ?>
                <li>
                    <a href="<?= base_url('/artikel/' . $row['slug']) ?>">
                        <?= esc($row['judul']) ?>
                    </a>
                    <br>
                    <small style="color:#999;">
                        <?= date('d M Y', strtotime($row['created_at'])) ?>
                    </small>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Belum ada artikel.</li>
        <?php endif; ?>
    </ul>
</div>