<?php
// register.php
require_once 'inc/config.php';
require_once 'inc/template.php';

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';
$username_input = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $username_input = $username;

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Semua kolom wajib diisi.';
    } elseif ($password !== $confirm_password) {
        $error = 'Konfirmasi password tidak cocok.';
    } elseif (strlen($password) < 4) {
        $error = 'Password minimal 4 karakter.';
    } else {
        try {
            // Cek apakah username sudah ada
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = 'Username sudah digunakan.';
            } else {
                // HATI-HATI: PASSWORD DISIMPAN DALAM PLAIN TEXT
                $plain_password = $password; 
                
                // Masukkan user baru dengan role 'user'
                $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
                $stmt->execute([$username, $plain_password]);
                
                $success = 'Registrasi berhasil! Silakan <a href="login.php" class="alert-link">Login</a>.';
                $username_input = ''; // Kosongkan input setelah sukses
            }
        } catch (PDOException $e) {
            $error = "Registrasi gagal: " . $e->getMessage();
        }
    }
}

html_header('Registrasi Akun');
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h2 class="text-center mb-4 text-primary">Registrasi Akun User</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username_input); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                    <p class="text-center mt-3"><a href="login.php">Sudah punya akun? Login di sini.</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php html_footer(); ?>