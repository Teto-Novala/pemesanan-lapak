<?php
include 'config.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($username === '' || $password === '' || $email === '') {
        $error = 'Semua kolom wajib diisi.';
    } else {
        // Cek apakah username atau email sudah ada
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $error = 'Username atau email sudah digunakan.';
        } else {
            // Simpan user baru
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                $success = 'Registrasi berhasil! Silakan login.';
            } else {
                $error = 'Terjadi kesalahan saat menyimpan data.';
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="card mx-auto shadow-sm" style="max-width:400px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">Register</h3>

      <?php if($error): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
      <?php elseif($success): ?>
        <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100 mb-2">Daftar</button>
        <a href="login.php" class="btn btn-outline-secondary w-100 mb-2">Sudah punya akun? Login</a>
        <a href="index.php" class="btn btn-link w-100">Kembali ke Beranda</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
