<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
  header('Location: admin_login.php');
  exit;
}
// ambil semua pesanan
$pesanans = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">Admin - Pemesanan Lapak</a>
      <div>
        <a class="btn btn-outline-light" href="logout.php">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>Daftar Pesanan</h3>
      <div>
        <a href="dashboard_export_pdf.php" target="_blank" class="btn btn-danger me-2">
          Export PDF
        </a>
        <a href="kelola_lapak.php" class="btn btn-primary">Kelola Lapak</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>No Lapak</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($p = $pesanans->fetch_assoc()):
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($p['username']) ?></td>
              <td><?= htmlspecialchars($p['tanggal']) ?></td>
              <td><?= htmlspecialchars($p['no_lapak']) ?></td>
              <td>
                <?php if ($p['status'] == 'menunggu'): ?>
                  <span class="badge bg-secondary">Menunggu</span>
                <?php elseif ($p['status'] == 'disetujui'): ?>
                  <span class="badge bg-success">Disetujui</span>
                <?php elseif ($p['status'] == 'ditolak'): ?>
                  <span class="badge bg-danger">Ditolak</span>
                <?php else: ?>
                  <?= htmlspecialchars($p['status']) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($p['status'] == 'menunggu'): ?>
                  <a href="ubah_status.php?id=<?= urlencode($p['id']) ?>&action=setujui" class="btn btn-sm btn-success" onclick="return confirm('Setujui pesanan ini?')">Setujui</a>

                  <a href="ubah_status.php?id=<?= urlencode($p['id']) ?>&action=tolak" class="btn btn-sm btn-warning text-white" onclick="return confirm('Tolak pesanan ini?')">Tolak</a>
                <?php endif; ?>

                <a href="ubah_status.php?id=<?= urlencode($p['id']) ?>&action=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pesanan?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>