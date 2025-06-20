<?php
session_start();
include '../../includes/connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_buku = $_POST['buku_id'] ?? null;
    $id_anggota = $_SESSION['user']['id'] ?? null;
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'] ?? null;
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'] ?? null;

    if (!$id_buku || !$id_anggota || !$tanggal_peminjaman || !$tanggal_pengembalian) {
        die("Data tidak lengkap.");
    }

    $stmt = $conn->prepare("INSERT INTO peminjaman (id_buku, id_anggota, tanggal_peminjaman, tanggal_pengembalian, status) VALUES (?, ?, ?, ?, 'dipinjam')");
    $stmt->bind_param("iiss", $id_buku, $id_anggota, $tanggal_peminjaman, $tanggal_pengembalian);

    if ($stmt->execute()) {
        $conn->query("UPDATE buku SET stok = stok - 1 WHERE id = $id_buku AND stok > 0");
        header("Location: riwayat.php");
        exit;
    } else {
        echo "Gagal menyimpan peminjaman.";
    }
} else {
    echo "Akses tidak valid.";
}
