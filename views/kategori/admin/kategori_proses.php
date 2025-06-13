<?php
include '../../../includes/connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nama_kategori = trim($_POST['nama_kategori']);

    // Validasi input kosong
    if (empty($nama_kategori)) {
        die("Nama kategori tidak boleh kosong.");
    }

    // Cek apakah nama kategori sudah ada (unik)
    $checkQuery = "SELECT id FROM kategori_buku WHERE nama_kategori = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "si", $nama_kategori, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        die("Kategori dengan nama ini sudah ada.");
    }
    mysqli_stmt_close($stmt);

    // Jika ID ada, update. Jika tidak, insert baru
    if ($id > 0) {
        $query = "UPDATE kategori_buku SET nama_kategori = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $nama_kategori, $id);
    } else {
        $query = "INSERT INTO kategori_buku (nama_kategori) VALUES (?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $nama_kategori);
    }

    // Eksekusi query insert/update
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: admin_kategori.php");
        exit;
    } else {
        mysqli_stmt_close($stmt);
        die("Gagal menyimpan data.");
    }
} else {
    die("Akses tidak sah.");
}
?>
