<?php
require 'config.php';
require_login();

$stmt = $pdo->query("SELECT id, name, filename FROM ebooks ORDER BY id ASC");
$ebooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="assets/style.css">
<script>
function openViewer(id) {
    const frame = document.getElementById('viewer');
    frame.src = 'view.php?id=' + id + '#toolbar=0';
    document.getElementById('pdfbox').scrollIntoView({behavior: 'smooth'});
}
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        alert('⚠️ Anda berpindah tab. Harap kembali ke halaman ini.');
    }
});
</script>
</head>
<body>
<header>
  <h1>Daftar eBook</h1>
  <div>
    <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
    <a href="logout.php" style="color:white; text-decoration:none;">Logout</a>
  </div>
</header>

<main>
<table>
<tr><th>No</th><th>Nama eBook</th><th>Aksi</th></tr>
<?php foreach ($ebooks as $i => $e): ?>
<tr>
  <td><?= $i+1 ?></td>
  <td><?= htmlspecialchars($e['name']) ?></td>
  <td>
    <div class="table-action">
        <a class="btn btn-view" href="#" onclick="openViewer(<?= $e['id'] ?>)">Lihat</a>
        <a class="btn btn-del" href="delete.php?id=<?= $e['id'] ?>" onclick="return confirm('Hapus eBook ini?')">Hapus</a>
    </div>
  </td>
</tr>
<?php endforeach; ?>
</table>

<div id="pdfbox">
  <iframe id="viewer" width="100%" height="600px" frameborder="0"></iframe>
  <div class="overlay">PDF dilindungi (tidak dapat diunduh langsung)</div>
</div>
</main>
</body>
</html>