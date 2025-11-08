<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit;
}

$lapaks = $conn->query("SELECT * FROM lapak ORDER BY id ASC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelola Lapak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="admin_dashboard.php">Admin - Pemesanan Lapak</a>
    <div>
      <a class="btn btn-outline-light" href="logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Lapak</h3>
    <a href="lapak_tambah.php" class="btn btn-primary">+ Tambah Lapak</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>No Lapak</th>
          <th>Status</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($l = $lapaks->fetch_assoc()): ?>
        <tr>
          <td><?=$l['id']?></td>
          <td><?=$l['no_lapak']?></td>
          <td><?=$l['status']?></td>
          <td>
            <?php if($l['gambar']): ?>
              <img src="uploads/<?=$l['gambar']?>" alt="Gambar Lapak" width="80" class="rounded">
            <?php else: ?>
              <small class="text-muted">Tidak ada</small>
            <?php endif; ?>
          </td>
          <td>
            <a href="lapak_edit.php?id=<?=$l['id']?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="lapak_hapus.php?id=<?=$l['id']?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>
</body>
</html>
