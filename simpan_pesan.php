<?php
session_start();
include 'config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_logged'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_lapak = (int)$_POST['no_lapak'];
    $username = $_SESSION['username'];

    // Ambil data user
    $stmt_user = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $user = $stmt_user->get_result()->fetch_assoc();

    // Cek lapak
    $stmt_lapak = $conn->prepare("SELECT * FROM lapak WHERE no_lapak = ?");
    $stmt_lapak->bind_param("i", $no_lapak);
    $stmt_lapak->execute();
    $lapak = $stmt_lapak->get_result()->fetch_assoc();

    if (!$lapak || $lapak['status'] != 'kosong') {
        die('Lapak tidak tersedia.');
    }

    // Update status lapak
    $stmt_update = $conn->prepare("UPDATE lapak SET status = 'dipesan' WHERE no_lapak = ?");
    $stmt_update->bind_param("i", $no_lapak);
    $stmt_update->execute();

    $conn->query("INSERT INTO pesanan (username, no_lapak, tanggal) VALUES ('$username', '$no_lapak', NOW())");

    // === Kirim email ke admin pakai FormSubmit ===
    $adminEmail = "tetonoval@gmail.com"; // Ganti dengan email admin kamu

    // Redirect ke FormSubmit sambil kirim data
    $params = http_build_query([
        '_subject' => "Pesanan Baru Lapak #$no_lapak",
        'Lapak' => "No. $no_lapak",
        'Username' => $user['username'],
        'Email Pengguna' => $user['email'],
        '_template' => 'table',
        '_next' => 'http://localhost/pemesanan/terima_kasih.php'
    ]);

    header("Location: index.php");
    exit;
}
?>
