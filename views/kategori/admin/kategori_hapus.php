<?php
// Sesuaikan path koneksi database
include '../../../includes/connection_db.php';

// Cek apakah ada parameter id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cek apakah kategori masih memiliki relasi ke tabel buku
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM buku WHERE id_kategori = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($total > 0) {
        // Jika masih ada buku dalam kategori, tolak penghapusan
        die("Tidak dapat menghapus kategori karena masih ada buku yang terkait.");
    }

    // Jika aman, lakukan penghapusan
    $stmt_delete = mysqli_prepare($conn, "DELETE FROM kategori_buku WHERE id = ?");
    mysqli_stmt_bind_param($stmt_delete, "i", $id);

    if (mysqli_stmt_execute($stmt_delete)) {
        mysqli_stmt_close($stmt_delete);
        header("Location: admin_kategori.php");
        exit;
    } else {
        mysqli_stmt_close($stmt_delete);
        die("Gagal menghapus kategori.");
    }
} else {
    die("ID kategori tidak ditemukan.");
}
?>
