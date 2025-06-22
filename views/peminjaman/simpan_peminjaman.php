<?php
include '../../includes/connection_db.php';
session_start();

// Cek jika user sudah login
if (!isset($_SESSION['user']['id'])) {
    header("Location: ../../login.php");
    exit();
}

// Ambil data dari form
$id_anggota = intval($_SESSION['user']['id']);
$id_buku = isset($_POST['buku_id']) ? intval($_POST['buku_id']) : 0;
$tanggal_pinjam = $_POST['tanggal_peminjaman'] ?? '';

// Validasi input
if (!$id_buku || empty($tanggal_pinjam)) {
    echo "Data tidak lengkap. Harap isi semua field.";
    exit();
}

// Cek stok buku
$cekStok = mysqli_query($conn, "SELECT stok FROM buku WHERE id = $id_buku");
$dataStok = mysqli_fetch_assoc($cekStok);
if ($dataStok['stok'] <= 0) {
    echo "Stok buku habis, tidak bisa dipinjam.";
    exit();
}

// Hitung tanggal pengembalian otomatis +7 hari dari tanggal pinjam
$timestamp = strtotime($tanggal_pinjam);
if (!$timestamp) {
    echo "Format tanggal tidak valid.";
    exit();
}
$tanggal_kembali = date('Y-m-d', strtotime('+7 days', $timestamp));

// Simpan ke tabel peminjaman
$query = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_peminjaman, tanggal_pengembalian, status) 
          VALUES (?, ?, ?, ?, 'dipinjam')";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'iiss', $id_anggota, $id_buku, $tanggal_pinjam, $tanggal_kembali);

if (mysqli_stmt_execute($stmt)) {
    // Kurangi stok buku
    $updateStok = "UPDATE buku SET stok = stok - 1 WHERE id = ?";
    $stokStmt = mysqli_prepare($conn, $updateStok);
    mysqli_stmt_bind_param($stokStmt, 'i', $id_buku);
    mysqli_stmt_execute($stokStmt);

    // Redirect ke halaman riwayat
    header("Location: riwayat.php");
    exit();
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}
?>
