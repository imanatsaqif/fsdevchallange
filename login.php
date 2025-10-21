<?php
// login.php
require 'config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $errors[] = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth">
<div class="card">
    <h2>Login</h2>
    <?php foreach($errors as $e): ?><div class="alert"><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Masuk</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</div>
</body>
</html>
