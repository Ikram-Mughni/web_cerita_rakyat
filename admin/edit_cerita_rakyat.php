<?php
// admin/edit_artikel.php
require_once '../inc/config.php';
require_once '../inc/template.php';
check_admin_login();

$error = '';
$article = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // SINKRONISASI
    header('Location: kelola_cerita_rakyat.php');
    exit;
}

$article_id = $_GET['id'];

// Ambil data artikel yang akan diedit
// (SINKRONISASI) Mengubah 'articles' menjadi 'cerita'
$stmt = $pdo->prepare("SELECT * FROM cerita WHERE id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
    // SINKRONISASI
    header('Location: kelola_cerita_rakyat.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $old_image = $_POST['old_image'] ?? '';
    $current_image = $old_image;

    if (empty($title) || empty($content)) {
        // SINKRONISASI
        $error = "Judul dan Isi cerita rakyat wajib diisi.";
    } else {
        // Logika Upload Gambar Baru
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            $max_size = 5 * 1024 * 1024; // 5 MB

            if (!in_array($file_ext, $allowed_ext)) {
                $error = "Ekstensi file tidak valid. Hanya JPG, JPEG, PNG, GIF yang diizinkan.";
            } elseif ($_FILES['image']['size'] > $max_size) {
                $error = "Ukuran file terlalu besar (maks 5MB).";
            } else {
                $new_image_name = uniqid('img_') . '.' . $file_ext;
                $upload_dir = '../assets/uploads/';
                
                if (move_uploaded_file($file_tmp, $upload_dir . $new_image_name)) {
                    // Hapus gambar lama
                    if ($old_image && file_exists($upload_dir . $old_image)) {
                        unlink($upload_dir . $old_image);
                    }
                    $current_image = $new_image_name;
                } else {
                    $error = "Gagal mengupload gambar baru.";
                }
            }
        }

        // Jika tidak ada error, update ke database
        if (!$error) {
            try {
                // (SINKRONISASI) Mengubah nama tabel
                $stmt = $pdo->prepare("UPDATE cerita SET title = ?, content = ?, image = ? WHERE id = ?");
                $stmt->execute([$title, $content, $current_image, $article_id]);
                // SINKRONISASI
                header('Location: kelola_cerita_rakyat.php?status=updated');
                exit;
            } catch (PDOException $e) {
                $error = "Gagal memperbarui artikel: " . $e->getMessage();
            }
        }
        
        // Muat ulang data artikel setelah gagal update
        $article['title'] = $title;
        $article['content'] = $content;
        $article['image'] = $current_image;
    }
}

html_header('Edit Artikel: ' . $article['title']);
?>

<!-- SINKRONISASI -->
<h2 class="mb-4 text-primary">Edit Cerita Rakyat</h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($article['image'] ?? ''); ?>">

    <div class="mb-3">
        <!-- SINKRONISASI -->
        <label for="title" class="form-label">Judul Cerita Rakyat</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
    </div>
    <div class="mb-3">
        <!-- SINKRONISASI -->
        <label for="content" class="form-label">Isi Cerita Rakyat</label>
        <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($article['content']); ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="image" class="form-label">Ganti Gambar (Maks 5MB, JPG/PNG/GIF)</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        
        <?php if ($article['image'] && file_exists('../assets/uploads/' . $article['image'])): ?>
            <p class="mt-2">Gambar saat ini:</p>
            <img src="../assets/uploads/<?php echo htmlspecialchars($article['image']); ?>" alt="Gambar Saat Ini" style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
        <?php else: ?>
            <p class="mt-2 text-muted">Belum ada gambar.</p>
        <?php endif; ?>
    </div>
    <!-- SINKRONISASI -->
    <button type="submit" class="btn btn-primary">Update Cerita rakyat</button>
    <!-- SINKRONISASI -->
    <a href="kelola_cerita_rakyat.php" class="btn btn-secondary">Batal</a>
</form>

<?php html_footer(); ?>