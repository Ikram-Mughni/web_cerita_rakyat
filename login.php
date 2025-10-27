<?php
// login.php
require_once 'inc/config.php';
require_once 'inc/template.php';

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';
$redirect_to = $_SESSION['redirect_url'] ?? 'index.php';
unset($_SESSION['redirect_url']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Ambil user dari database
    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->execute([$username]); 
    $user = $stmt->fetch();

    // Perbandingan Plain Text Password
    if ($user && $password === $user['password']) {
        // Login Berhasil
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // Arahkan ke halaman admin jika admin, atau ke halaman sebelumnya
        if ($user['role'] === 'admin') {
            // SINKRONISASI
            header('Location: admin/kelola_cerita_rakyat.php');
        } else {
            header('Location: ' . $redirect_to);
        }
        exit;
    } else {
        $error = 'Username atau Password salah.';
    }
}

html_header('Login');
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h2 class="text-center mb-4 text-primary">Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <p class="text-center mt-3"><a href="register.php">Belum punya akun? Daftar di sini.</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php html_footer(); ?>