<?php
require 'config.php';
require_login();

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT filename FROM ebooks WHERE id = ?");
$stmt->execute([$id]);
$file = $stmt->fetchColumn();

if (!$file) {
    http_response_code(404);
    echo "File tidak ditemukan.";
    exit;
}

$path = __DIR__ . "/pdfs/" . basename($file);
if (!file_exists($path)) {
    http_response_code(404);
    echo "PDF tidak ditemukan di folder.";
    exit;
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($file) . '"');
readfile($path);
