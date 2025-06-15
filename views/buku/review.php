<?php
session_start();
include '../../includes/connection_db.php';


if (!isset($_SESSION['user'])) {
    header("Location: ../../public/auth/login.php");
    exit;
}

$id_user = $_SESSION['user']['id'];
$id_buku = isset($_POST['book_id']) ? (int) $_POST['book_id'] : 0;
$rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
$komentar = trim($_POST['komentar']);

if ($id_buku <= 0 || $rating < 1 || $rating > 5 || empty($komentar)) {
    die("Input tidak valid.");
}

$stmt = $conn->prepare("SELECT * FROM ulasan_buku WHERE id_buku = ? AND id_anggota = ?");
$stmt->bind_param("ii", $id_buku, $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Anda sudah memberikan ulasan untuk buku ini.");
}

$insert = $conn->prepare("INSERT INTO ulasan_buku (id_buku, id_anggota, rating, komentar) VALUES (?, ?, ?, ?)");
$insert->bind_param("iiis", $id_buku, $id_user, $rating, $komentar);
$insert->execute();

header("Location: detail.php?id=" . $id_buku);
exit;
