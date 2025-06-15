<?php
include '../../includes/connection_db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../public/auth/login.php");
    exit;
}

$id_user = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

$id_ulasan = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$book_id = isset($_GET['book']) ? (int) $_GET['book'] : 0;

$stmt = $conn->prepare("SELECT * FROM ulasan_buku WHERE id = ?");
$stmt->bind_param("i", $id_ulasan);
$stmt->execute();
$result = $stmt->get_result();
$ulasan = $result->fetch_assoc();

if (!$ulasan) {
    die("Ulasan tidak ditemukan.");
}

if ($ulasan['id_anggota'] != $id_user && $role != 'admin') {
    die("Akses ditolak.");
}

$delete = $conn->prepare("DELETE FROM ulasan_buku WHERE id = ?");
$delete->bind_param("i", $id_ulasan);
$delete->execute();

header("Location: detail.php?id=" . $book_id);
exit;
