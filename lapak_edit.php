<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_logged'])) {
    header('Location: admin_login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM lapak WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$lapak = $result->fetch_assoc();

if (!$lapak) {
    die('Lapak tidak ditemukan.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_lapak = $_POST['no_lapak'];
    $status = $_POST['status'];
    $gambar = $lapak['gambar'];

    // Jika upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir);

        // Hapus gambar lama jika ada
        if ($gambar && file_exists("uploads/$gambar")) {
            unlink("uploads/$gambar");
        }

        $filename = time() . '_' . basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . $filename;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile);
        $gambar = $filename;
    }

    $stmt = $conn->prepare("UPDATE lapak SET no_lapak = ?, status = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("sssi", $no_lapak, $status, $gambar, $id);
    $stmt->execute();

    header('Location: admin_lapak.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Lapak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h3>Edit Lapak</h3>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">No Lapak</label>
      <input type="text" name="no_lapak" class="form-control" value="<?=htmlspecialchars($lapak['no_lapak'])?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="kosong" <?=($lapak['status'] == 'kosong') ? 'selected' : ''?>>Kosong</option>
        <option value="dipesan" <?=($lapak['status'] == 'dipesan') ? 'selected' : ''?>>Dipesan</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Gambar Lapak (biarkan kosong jika tidak diubah)</label>
      <?php if($lapak['gambar']): ?>
        <div class="mb-2">
          <img src="uploads/<?=$lapak['gambar']?>" alt="Gambar" width="100" class="rounded">
        </div>
      <?php endif; ?>
      <input type="file" name="gambar" class="form-control">
    </div>
    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="admin_lapak.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
