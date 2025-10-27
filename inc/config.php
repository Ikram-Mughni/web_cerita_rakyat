<?php
// inc/config.php

$host = 'localhost';
$db   = 'db_cerita_rakyat'; //SINKRONISASI
$user = 'root'; 
$pass = '';     

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi untuk cek apakah user sudah login sebagai ADMIN
function check_admin_login() {
    if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || $_SESSION['role'] !== 'admin') {
        header('Location: ../login.php');
        exit;
    }
}

// Fungsi untuk cek apakah user sudah login (user atau admin)
function check_user_login() {
    if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
        // Simpan halaman tujuan lengkap sebelum redirect
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit;
    }
}
?>