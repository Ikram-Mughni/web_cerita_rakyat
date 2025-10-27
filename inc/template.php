<?php
// inc/template.php

// Pastikan session_start() hanya dipanggil sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
$role = $_SESSION['role'] ?? 'guest';

function html_header($title = "Web Artikel Komentar") {
    $path_prefix = (basename(getcwd()) === 'admin') ? '../' : '';
    global $is_logged_in, $role;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>assets/CSS/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo $path_prefix; ?>index.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-bold" href="<?php echo $path_prefix; ?>index.php">Home</a></li>
                    <!-- SINKRONISASI -->
                    <li class="nav-item"><a class="nav-link fw-bold" href="<?php echo $path_prefix; ?>cerita_rakyat_list.php">Cerita</a></li>
                    
                    <?php if ($role === 'admin'): ?>
                        <!-- SINKRONISASI 2 -->
                        <li class="nav-item"><a class="nav-link bg-warning rounded-pill px-3 mx-2 text-dark fw-bold" href="<?php echo $path_prefix; ?>admin/kelola_cerita_rakyat.php">Kelola Cerita</a></li>
                    <?php endif; ?>
                    
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item">
                            <span class="nav-link text-info fw-bold">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($role); ?>)</span>
                        </li>
                        <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white" href="<?php echo $path_prefix; ?>logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link fw-bold" href="<?php echo $path_prefix; ?>register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="<?php echo $path_prefix; ?>login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-5">
        <div class="container">
<?php
}

function html_footer() {
    $path_prefix = (basename(getcwd()) === 'admin') ? '../' : '';
?>
        </div>
    </main>

    <footer class="footer bg-primary text-white text-center py-3 mt-auto">
        <p class="mb-0">&copy; 2025 Web Cerita rakyat. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $path_prefix; ?>assets/JS/script.js"></script>
</body>
</html>
<?php
}
?>