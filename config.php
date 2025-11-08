<?php
// config.php - koneksi database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'pemesanan_lapak';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>
