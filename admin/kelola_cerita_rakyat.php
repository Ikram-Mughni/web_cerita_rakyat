<?php
// admin/kelola_cerita_rakyat.php
require_once '../inc/config.php';
require_once '../inc/template.php';
check_admin_login();

// Logika Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Hapus gambar terkait
        // (SINKRONISASI) Mengubah nama tabel
        $stmt = $pdo->prepare("SELECT image FROM cerita WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch();
        if ($article && $article['image']) {
            $image_path = '../assets/uploads/' . $article['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        // Hapus cerita dari database (Komentar otomatis terhapus karena Foreign Key di InnoDB)
        // (SINKRONISASI) Mengubah nama tabel
        $stmt = $pdo->prepare("DELETE FROM cerita WHERE id = ?");
        $stmt->execute([$id]);
        //SINKRONISASI
        header('Location: kelola_cerita_rakyat.php?status=deleted');
        exit;
    } catch (PDOException $e) {
        //SINKRONISASI
        $error = "Gagal menghapus cerita: " . $e->getMessage();
    }
}

// Ambil semua cerita
// (SINKRONISASI) Mengubah nama tabel
$stmt = $pdo->query("SELECT * FROM cerita ORDER BY created_at DESC");
$articles = $stmt->fetchAll();

//SINKRONISASI
html_header('Kelola Cerita Rakyat');
?>

<!-- SINKRONISASI -->
<h2 class="mb-4 text-primary">Kelola Cerita rakyat</h2>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-<?php echo ($_GET['status'] == 'deleted' ? 'warning' : 'success'); ?>">
        <?php
        // SINKRONISASI 3
        if ($_GET['status'] == 'added') echo 'Cerita rakyat berhasil ditambahkan!';
        if ($_GET['status'] == 'updated') echo 'Cerita rakyat berhasil diperbarui!';
        if ($_GET['status'] == 'deleted') echo 'Cerita rakyat berhasil dihapus!';
        ?>
    </div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<!-- SINKRONISASI SINKRONISASI -->
<a href="tambah_cerita_rakyat.php" class="btn btn-success mb-3">Tambah Cerita Rakyat Baru</a>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $index => $article): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <?php if ($article['image'] && file_exists('../assets/uploads/' . $article['image'])): ?>
                            <img src="../assets/uploads/<?php echo htmlspecialchars($article['image']); ?>" alt="Gambar" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                        <?php else: ?>
                            <span class="text-muted">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($article['title']); ?></td>
                    <td><?php echo date('d M Y', strtotime($article['created_at'])); ?></td>
                    <td>
                        <!-- SINKRONISASI -->
                        <a href="edit_cerita_rakyat.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-info text-white">Edit</a>
                        <!-- SINKRONISASI -->
                        <a href="?action=delete&id=<?php echo $article['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus cerita rakyat: <?php echo htmlspecialchars($article['title']); ?>?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php html_footer(); ?>