<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_logged'])) {
  header('Location: admin_login.php');
  exit;
}

// Ambil semua data lapak
$result = $conn->query("SELECT * FROM lapak ORDER BY id DESC");
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
      <div>
        <a href="lapak_export_pdf.php" target="_blank" class="btn btn-danger me-2">
          <i class="bi bi-file-pdf"></i> Export PDF
        </a>
        <a href="lapak_tambah.php" class="btn btn-success">+ Tambah Lapak</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>No Lapak</th>
            <th>Status</th>
            <th>Gambar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['no_lapak']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
              <td>
                <?php if (!empty($row['gambar'])): ?>
                  <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar Lapak" width="80" class="rounded">
                <?php else: ?>
                  <span class="text-muted">Tidak ada</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="lapak_edit.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="lapak_hapus.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus lapak ini?')">Hapus</a>
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