<?php
session_start();
include 'config.php';
$lapaks = $conn->query("SELECT * FROM lapak ORDER BY no_lapak ASC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Lapak - Pemesanan Lapak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Pemesanan Lapak</a>
    <div class="d-flex gap-2">
      <?php if(isset($_SESSION['user_logged']) || isset($_SESSION['admin_logged'])): ?>
        <span class="navbar-text text-white me-2">
          Halo, <?= htmlspecialchars($_SESSION['username']) ?>
        </span>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline-light" href="login.php">Login</a>
        <a class="btn btn-light text-primary" href="register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="text-center mb-4">
    <h1>Daftar Lapak Bazar</h1>
    <p class="text-muted">Pilih nomor lapak lalu pesan secara online</p>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php while($lapak = $lapaks->fetch_assoc()): ?>
    <div class="col">
      <div class="card h-100 shadow-sm">
        
        <!-- ✅ Tambahkan bagian gambar -->
        <?php if (!empty($lapak['gambar']) && file_exists("uploads/" . $lapak['gambar'])): ?>
          <img src="uploads/<?= htmlspecialchars($lapak['gambar']) ?>" class="card-img-top" alt="Lapak #<?= htmlspecialchars($lapak['no_lapak']) ?>" style="height: 200px; object-fit: cover;">
        <?php else: ?>
          <img src="assets/img/no-image.png" class="card-img-top" alt="Tidak ada gambar" style="height: 200px; object-fit: cover;">
        <?php endif; ?>

        <div class="card-body text-center">
          <h5 class="card-title">Lapak #<?= htmlspecialchars($lapak['no_lapak']) ?></h5>
          <p class="card-text">Status: 
            <strong class="<?= $lapak['status'] == 'kosong' ? 'text-success' : 'text-danger' ?>">
              <?= htmlspecialchars($lapak['status']) ?>
            </strong>
          </p>

          <?php if($lapak['status'] == 'kosong'): ?>
            <?php if(isset($_SESSION['user_logged']) || isset($_SESSION['admin_logged'])): ?>
              <a href="pesan.php?no_lapak=<?= urlencode($lapak['no_lapak']) ?>" class="btn btn-primary">Pesan</a>
            <?php else: ?>
              <a href="login.php" class="btn btn-warning">Login untuk Pesan</a>
            <?php endif; ?>
          <?php else: ?>
            <button class="btn btn-secondary" disabled>Sudah Dipesan</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<footer class="text-center py-3">
  <small class="text-muted">Sistem Pemesanan Lapak Sederhana</small>
</footer>
</body>
</html>
