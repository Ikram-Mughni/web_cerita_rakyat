<?php
// cerita_rakyat.php
require_once 'inc/config.php';
require_once 'inc/template.php';

$article = null;
$error = '';
$is_logged_in = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
$admin_role = isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; 

// Ambil ID user yang sedang login (jika ada)
$current_user_id = $_SESSION['user_id'] ?? null; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    //SINKRONISASI
    header('Location: cerita_rakyat_list.php');
    exit;
}
$article_id = $_GET['id'];

// A. Ambil Detail Cerita
// (SINKRONISASI) ubah nama tabel
$stmt = $pdo->prepare("SELECT * FROM cerita WHERE id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
    // SINKRONISASI
    html_header('Cerita Rakyat Tidak Ditemukan');
    // SINKRONISASI
    echo '<div class="alert alert-danger text-center">Cerita rakyat tidak ditemukan.</div>';
    html_footer();
    exit;
}

// B. Logika Kirim Komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    
    if (!$is_logged_in) {
        check_user_login(); 
    }
    
    $comment_text = trim($_POST['comment_text'] ?? '');
    $user_id = $_SESSION['user_id']; 

    if (empty($comment_text)) {
        $error = 'Komentar tidak boleh kosong.';
    } else {
        try {
            // (SINKRONISASI) Mengubah nama kolom
            $stmt = $pdo->prepare("INSERT INTO comments (cerita_id, user_id, comment) VALUES (?, ?, ?)");
            $stmt->execute([$article_id, $user_id, $comment_text]);
            
            // SINKRONISASI
            header("Location: cerita_rakyat.php?id=$article_id#comments");
            exit;
        } catch (PDOException $e) {
            $error = "Gagal mengirim komentar: " . $e->getMessage();
        }
    }
}

// C. Logika Hapus Komentar (Diperluas untuk User & Admin)
if (isset($_GET['action']) && $_GET['action'] === 'delete_comment' && isset($_GET['comment_id']) && is_numeric($_GET['comment_id'])) {
    $comment_id_to_delete = $_GET['comment_id'];
    
    try {
        // Ambil data komentar yang akan dihapus
        $stmt_check = $pdo->prepare("SELECT user_id FROM comments WHERE id = ?");
        $stmt_check->execute([$comment_id_to_delete]);
        $comment_data = $stmt_check->fetch();

        // 1. Pastikan komentar itu ada
        // 2. Pastikan user yang login adalah ADMIN ATAU user_id komentar sama dengan user_id yang login
        if ($comment_data && ($admin_role || $comment_data['user_id'] == $current_user_id)) {
            $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
            $stmt->execute([$comment_id_to_delete]);
            
            // SINKRONISASI
            header("Location: cerita_rakyat.php?id=$article_id&status=comment_deleted#comments");
            exit;
        } else {
            $error = "Anda tidak memiliki izin untuk menghapus komentar ini.";
        }
        
    } catch (PDOException $e) {
        $error = "Gagal menghapus komentar: " . $e->getMessage();
    }
}

// D. Ambil Semua Komentar 
$stmt_comments = $pdo->prepare("
    SELECT 
        c.*, 
        u.username,
        u.role              
    FROM comments c
    JOIN users u ON c.user_id = u.id
    -- (SINKRONISASI) Mengubah nama kolom --
    WHERE c.cerita_id = ?
    ORDER BY c.created_at DESC
");
$stmt_comments->execute([$article_id]);
$comments = $stmt_comments->fetchAll();


html_header(htmlspecialchars($article['title']));
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <h1 class="fw-bold mb-4 text-primary"><?php echo htmlspecialchars($article['title']); ?></h1>
        <p class="text-muted mb-4">Dipublikasikan pada: <?php echo date('d M Y', strtotime($article['created_at'])); ?></p>
        
        <?php if ($article['image'] && file_exists('assets/uploads/' . $article['image'])): ?>
            <img src="assets/uploads/<?php echo htmlspecialchars($article['image']); ?>" class="img-fluid rounded shadow-sm mb-4" alt="<?php echo htmlspecialchars($article['title']); ?>" style="max-height: 400px; width: 100%; object-fit: cover;">
        <?php else: ?>
            <div class="bg-light text-center d-flex align-items-center justify-content-center text-muted rounded mb-4" style="height: 300px;">
                <span class="text-secondary">Tidak ada Gambar</span>
            </div>
        <?php endif; ?>

        <div class="article-content fs-5 text-justify">
            <?php echo nl2br(htmlspecialchars($article['content'])); ?>
        </div>
        
        <!-- SINKRONISASI 2 -->
        <a href="cerita_rakyat_list.php" class="btn btn-secondary mt-5">Kembali ke Daftar Cerita Rakyat</a>
        
        
        <hr class="my-5" id="comments">

        <h3 class="mb-4 text-primary">Komentar (<?php echo count($comments); ?>)</h3>
        
        <?php if (isset($_GET['status']) && $_GET['status'] == 'comment_deleted'): ?>
            <div class="alert alert-warning">Komentar berhasil dihapus.</div>
        <?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>


        <?php if ($is_logged_in): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Tulis Komentar Anda:</h5>
                    <!-- SINKRONISASI -->
                    <form method="POST" action="cerita_rakyat.php?id=<?php echo $article_id; ?>">
                        <input type="hidden" name="comment" value="1">
                        <div class="mb-3">
                            <textarea class="form-control" name="comment_text" rows="3" required placeholder="Tulis komentar..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Anda harus <a href="login.php?redirect_url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="alert-link">Login</a> untuk memberikan komentar.
            </div>
        <?php endif; ?>

        <div class="comment-list mt-5">
            <?php if (empty($comments)): ?>
                <!-- SINKRONISASI -->
                <p class="text-muted text-center">Belum ada komentar untuk cerita rakyat ini.</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="card mb-3 shadow-sm border-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-bold mb-1 text-primary">
                                        <?php echo htmlspecialchars($comment['username']); ?> 
                                        <?php if ($comment['role'] === 'admin'): ?>
                                            <span class="badge bg-danger">Admin</span>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-muted small">
                                        <?php echo date('d M Y H:i', strtotime($comment['created_at'])); ?>
                                    </p>
                                </div>
                                
                                <?php 
                                // Cek apakah Admin ATAU ID user komentar sama dengan ID user yang sedang login
                                if ($admin_role || ($is_logged_in && $comment['user_id'] == $current_user_id)): 
                                ?>
                                    <!-- SINKRONISASI -->
                                    <a href="cerita_rakyat.php?id=<?php echo $article_id; ?>&action=delete_comment&comment_id=<?php echo $comment['id']; ?>" 
                                       class="btn btn-sm btn-danger align-self-start" 
                                       onclick="return confirm('Yakin ingin menghapus komentar ini?');">Hapus</a>
                                <?php endif; ?>
                                
                            </div>
                            <p class="card-text">
                                <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        </div>
</div>

<?php html_footer(); ?>