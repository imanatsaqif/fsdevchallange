<?php
// register.php
require 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (!$username || !$pass) {
        $errors[] = "Semua kolom wajib diisi.";
    } else {
        $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $check->execute([$username]);
        if ($check->fetch()) {
            $errors[] = "Username sudah digunakan.";
        }
    }

    if (empty($errors)) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);
        header('Location: login.php?register=success');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth">
<div class="card">
    <h2>Register</h2>
    <?php foreach($errors as $e): ?><div class="alert"><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</body>
</html>
