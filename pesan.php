<?php
session_start();
include 'config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_logged'])) {
    header("Location: login.php");
    exit;
}

$no_lapak = isset($_GET['no_lapak']) ? (int)$_GET['no_lapak'] : 0;

// cek apakah lapak tersedia
$stmt = $conn->prepare("SELECT * FROM lapak WHERE no_lapak = ?");
$stmt->bind_param("i", $no_lapak);
$stmt->execute();
$res = $stmt->get_result();
$lapak = $res->fetch_assoc();

if (!$lapak || $lapak['status'] != 'kosong') {
    header("Location: index.php?error=lapak_tidak_tersedia");
    exit;
}

// Ambil data user yang login
$username = $_SESSION['username'];
$user_stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user = $user_stmt->get_result()->fetch_assoc();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesan Lapak #<?=$no_lapak?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="card mx-auto" style="max-width:600px;">
    <div class="card-body">
      <h3 class="card-title mb-4">Pesan Lapak #<?=htmlspecialchars($no_lapak)?></h3>
      <form action="simpan_pesan.php" method="post">
        <input type="hidden" name="no_lapak" value="<?=htmlspecialchars($no_lapak)?>">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" value="<?=htmlspecialchars($user['username'])?>" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="text" class="form-control" value="<?=htmlspecialchars($user['email'])?>" readonly>
        </div>
        <button class="btn btn-primary">Konfirmasi Pesanan</button>
        <a href="index.php" class="btn btn-link">Batal</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
