<?php
// article_list.php
require_once 'inc/config.php';
require_once 'inc/template.php';

// Ambil SEMUA artikel
// (SINKRONISASI) Mengubah nama tabel
$stmt = $pdo->query("SELECT id, title, content, image FROM cerita ORDER BY created_at DESC");
$articles = $stmt->fetchAll();

html_header('Daftar Semua Artikel');
?>

<!-- SINKRONISASI -->
<h1 class="fw-bold text-primary mb-5 text-center">Semua Cerita Rakyat</h1>

<div class="row">
    <?php if (empty($articles)): ?>
        <!-- SINKRONISASI -->
        <p class="text-center text-muted">Belum ada Cerita Rakyat yang dipublikasikan.</p>
    <?php endif; ?>

    <?php foreach ($articles as $article): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <?php if ($article['image'] && file_exists('assets/uploads/' . $article['image'])): ?>
                    <img src="assets/uploads/<?php echo htmlspecialchars($article['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['title']); ?>" style="height: 200px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-light text-center d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                        <span class="text-secondary">Tidak ada Gambar</span>
                    </div>
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($article['title']); ?></h5>
                    <p class="card-text text-muted"><?php echo substr(strip_tags($article['content']), 0, 100) . '...'; ?></p>
                    <!-- SINKRONISASI -->
                    <a href="cerita_rakyat.php?id=<?php echo $article['id']; ?>" class="mt-auto btn btn-outline-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php html_footer(); ?>