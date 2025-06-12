<?php
session_start();
include '../../includes/connection_db.php'; 

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk tindakan ini.";
    header("Location: collection.php");
    exit;
}

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $_SESSION['error'] = "Permintaan tidak valid. ID buku tidak ditemukan.";
    header("Location: collection.php");
    exit;
}

$book_id = $_GET['id'];

$query_select_image = "SELECT image_path FROM buku WHERE id = ?";
$stmt_select = mysqli_prepare($conn, $query_select_image);
mysqli_stmt_bind_param($stmt_select, "i", $book_id);
mysqli_stmt_execute($stmt_select);
$result_image = mysqli_stmt_get_result($stmt_select);
$book = mysqli_fetch_assoc($result_image);

if ($book && !empty($book['image_path'])) {
    $filename = basename($book['image_path']);
    
    $physical_path = '../public/images/buku/' . $filename;
    
    if (file_exists($physical_path)) {
        unlink($physical_path);
    }
}

$query_delete = "DELETE FROM buku WHERE id = ?";
$stmt_delete = mysqli_prepare($conn, $query_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $book_id);

if (mysqli_stmt_execute($stmt_delete)) {
    if (mysqli_stmt_affected_rows($stmt_delete) > 0) {
        $_SESSION['success'] = "Buku berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Buku tidak ditemukan atau sudah dihapus sebelumnya.";
    }
} else {
    $_SESSION['error'] = "Terjadi kesalahan saat menghapus data buku: " . mysqli_stmt_error($stmt_delete);
}
header("Location: collection.php");
exit;
?>