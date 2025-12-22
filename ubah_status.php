<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = $_GET['action'] ?? '';

if ($id <= 0) {
    header('Location: admin_dashboard.php');
    exit;
}


if ($action === 'setujui') {
    $stmt = $conn->prepare("UPDATE pesanan SET status = 'disetujui' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: admin_dashboard.php');
    exit;
} elseif ($action === 'tolak') {
    $stmt = $conn->prepare("UPDATE pesanan SET status = 'ditolak' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt_get = $conn->prepare("SELECT no_lapak FROM pesanan WHERE id = ?");
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $res = $stmt_get->get_result();
    $row = $res->fetch_assoc();

    if ($row) {
        $no_lapak = $row['no_lapak'];
        $stmt_lapak = $conn->prepare("UPDATE lapak SET status = 'kosong' WHERE no_lapak = ?");
        $stmt_lapak->bind_param("i", $no_lapak);
        $stmt_lapak->execute();
    }

    header('Location: admin_dashboard.php');
    exit;
} elseif ($action === 'hapus') {
    $stmt = $conn->prepare("SELECT no_lapak FROM pesanan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if ($row) {
        $no_lapak = $row['no_lapak'];

        $stmt2 = $conn->prepare("DELETE FROM pesanan WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        $stmt3 = $conn->prepare("UPDATE lapak SET status = 'kosong' WHERE no_lapak = ?");
        $stmt3->bind_param("i", $no_lapak);
        $stmt3->execute();
    }

    header('Location: admin_dashboard.php');
    exit;
} else {
    header('Location: admin_dashboard.php');
    exit;
}
