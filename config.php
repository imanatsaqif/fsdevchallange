<?php
//config.php

session_start();

$host = '127.0.0.1';
$dbname = 'fsdev_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Cek login sebelum akses halaman
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
?>
