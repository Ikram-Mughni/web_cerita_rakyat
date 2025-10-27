<?php
// admin/tambah_artikel.php
require_once '../inc/config.php';
require_once '../inc/template.php';
check_admin_login();

$error = '';
$title = '';
$content = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image_name = null;

    if (empty($title) || empty($content)) {
        $error = "Judul dan Isi artikel wajib diisi.";
    } else {
        // Logika Upload Gambar
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
                $image_name = uniqid('img_') . '.' . $file_ext;
                $upload_dir = '../assets/uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                if (!move_uploaded_file($file_tmp, $upload_dir . $image_name)) {
                    $error = "Gagal mengupload gambar.";
                    $image_name = null;
                }
            }
        }

        // Jika tidak ada error, simpan ke database
        if (!$error) {
            try {
                // (SINKRONISASI) Mengubah nama tabel
                $stmt = $pdo->prepare("INSERT INTO cerita (title, content, image) VALUES (?, ?, ?)");
                $stmt->execute([$title, $content, $image_name]);
                // SINKRONISASI
                header('Location: kelola_cerita_rakyat.php?status=added');
                exit;
            } catch (PDOException $e) {
                $error = "Gagal menyimpan artikel: " . $e->getMessage();
            }
        }
    }
}

html_header('Tambah Artikel');
?>

<!-- SINKRONISASI -->
<h2 class="mb-4 text-primary">Tambah Cerita Rakyat Baru</h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <!-- SINKRONISASI -->
        <label for="title" class="form-label">Judul Cerita Rakyat</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
    </div>
    <div class="mb-3">
        <!-- SINKRONISASI -->
        <label for="content" class="form-label">Isi Cerita rakyat</label>
        <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($content); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Gambar (Maks 5MB, JPG/PNG/GIF)</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    
    <!-- SINKRONISASI -->
    <button type="submit" class="btn btn-primary">Simpan Cerita rakyat</button>
    <!-- SINKRONISASI -->
    <a href="kelola_cerita_rakyat.php" class="btn btn-secondary">Batal</a>
</form>

<?php html_footer(); ?>