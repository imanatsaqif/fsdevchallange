<?php
require 'config.php';
require_login();

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT filename FROM ebooks WHERE id=?");
$stmt->execute([$id]);
$file = $stmt->fetchColumn();

if ($file) {
    $path = __DIR__ . "/pdfs/" . basename($file);
    if (file_exists($path)) unlink($path);
    $pdo->prepare("DELETE FROM ebooks WHERE id=?")->execute([$id]);
}
header("Location: dashboard.php");
