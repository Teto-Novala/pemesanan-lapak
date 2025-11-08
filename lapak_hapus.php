<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_logged'])) {
    header('Location: admin_login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data gambar dulu
$stmt = $conn->prepare("SELECT gambar FROM lapak WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    // Hapus gambar jika ada
    if ($data['gambar'] && file_exists("uploads/" . $data['gambar'])) {
        unlink("uploads/" . $data['gambar']);
    }

    // Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM lapak WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header('Location: admin_lapak.php');
exit;
?>
