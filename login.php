<?php
include 'config.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Cek di tabel admin terlebih dahulu
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();
    $admin = $res->fetch_assoc();

    if ($admin) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = 'admin';
        header('Location: admin_dashboard.php');
        exit;
    } else {
        // Jika bukan admin, cek di tabel user
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();

        if ($user) {
            $_SESSION['user_logged'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'user';
            header('Location: index.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="card mx-auto shadow-sm" style="max-width:400px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">Login</h3>
      <?php if($error): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100 mb-2">Masuk</button>
        <a href="register.php" class="btn btn-outline-secondary w-100 mb-2">Register</a>
        <a href="index.php" class="btn btn-link w-100">Kembali ke Beranda</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
