<?php
session_start();
// Path ../../ karena file ini ada di dalam folder admin
include '../includes/connection_db.php'; 

// =================================================================
// 1. KEAMANAN: Pastikan hanya admin yang bisa mengakses
// =================================================================
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk tindakan ini.";
    header("Location: collection.php");
    exit;
}

// =================================================================
// 2. VALIDASI INPUT: Pastikan ID ada dan merupakan angka
// =================================================================
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $_SESSION['error'] = "Permintaan tidak valid. ID buku tidak ditemukan.";
    header("Location: collection.php");
    exit;
}

$book_id = $_GET['id'];

// =================================================================
// 3. HAPUS FILE GAMBAR (JIKA ADA)
// =================================================================
// Pertama, kita ambil dulu path gambar dari database sebelum datanya dihapus.
$query_select_image = "SELECT image_path FROM buku WHERE id = ?";
$stmt_select = mysqli_prepare($conn, $query_select_image);
mysqli_stmt_bind_param($stmt_select, "i", $book_id);
mysqli_stmt_execute($stmt_select);
$result_image = mysqli_stmt_get_result($stmt_select);
$book = mysqli_fetch_assoc($result_image);

if ($book && !empty($book['image_path'])) {
    // Dapatkan nama file dari path yang tersimpan di DB
    // contoh: dari /sipermi/public/images/buku/file.jpg menjadi file.jpg
    $filename = basename($book['image_path']);
    
    // Bentuk path fisik file di server
    // Path ../ karena kita berada di dalam folder admin
    $physical_path = '../public/images/buku/' . $filename;
    
    // Cek apakah file benar-benar ada, lalu hapus
    if (file_exists($physical_path)) {
        unlink($physical_path);
    }
}

// =================================================================
// 4. HAPUS DATA BUKU DARI DATABASE
// =================================================================
$query_delete = "DELETE FROM buku WHERE id = ?";
$stmt_delete = mysqli_prepare($conn, $query_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $book_id);

// Jalankan query delete
if (mysqli_stmt_execute($stmt_delete)) {
    // Cek apakah ada baris yang benar-benar terhapus
    if (mysqli_stmt_affected_rows($stmt_delete) > 0) {
        $_SESSION['success'] = "Buku berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Buku tidak ditemukan atau sudah dihapus sebelumnya.";
    }
} else {
    $_SESSION['error'] = "Terjadi kesalahan saat menghapus data buku: " . mysqli_stmt_error($stmt_delete);
}

// =================================================================
// 5. KEMBALIKAN ADMIN KE HALAMAN KOLEKSI
// =================================================================
header("Location: collection.php");
exit;
?>