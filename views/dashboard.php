<?php
session_start();
include '../includes/connection_db.php';

if (!isset($_SESSION['user'])) {
  header("Location: /SIPERMI/public/auth/login.php");
  exit();
}

$id_user = $_SESSION['user']['id'] ?? null;
$role = $_SESSION['user']['role'] ?? 'anggota';
$is_admin = $role === 'admin';

// --- Untuk Admin
if ($is_admin) {
  $jumlah_buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM buku"))['total'];
  $jumlah_anggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota WHERE role = 'user'"))['total'];
  $jumlah_peminjaman = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman"))['total'];

  $peminjaman = mysqli_query($conn, "SELECT p.*, u.nama, b.judul FROM peminjaman p 
    JOIN anggota u ON p.id_anggota = u.id 
    JOIN buku b ON p.id_buku = b.id 
    ORDER BY p.tanggal_peminjaman DESC");

} else {
  // --- Untuk Anggota
  $jumlah_buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE id_anggota = $id_user AND status = 'dipinjam'"))['total'];

  $peminjaman = mysqli_query($conn, "SELECT p.*, b.judul FROM peminjaman p 
    JOIN buku b ON p.id_buku = b.id 
    WHERE p.id_anggota = $id_user 
    ORDER BY p.tanggal_peminjaman DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard <?= ucfirst($role); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">
  <?php include '../includes/header.php'; ?>

  <main class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-6 text-[#0978B6]">Dashboard <?= ucfirst($role); ?></h1>

    <!-- Kartu Ringkasan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
      <?php if ($is_admin): ?>
        <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
          <h2 class="text-lg font-semibold text-gray-600">Jumlah Koleksi Buku</h2>
          <p class="text-4xl font-bold text-[#0978B6] mt-2"><?= $jumlah_buku; ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
          <h2 class="text-lg font-semibold text-gray-600">Jumlah Anggota</h2>
          <p class="text-4xl font-bold text-[#0978B6] mt-2"><?= $jumlah_anggota; ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
          <h2 class="text-lg font-semibold text-gray-600">Jumlah Peminjaman</h2>
          <p class="text-4xl font-bold text-[#0978B6] mt-2"><?= $jumlah_peminjaman; ?></p>
        </div>
      <?php else: ?>
        <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
          <h2 class="text-lg font-semibold text-gray-600">Buku Dipinjam</h2>
          <p class="text-4xl font-bold text-[#0978B6] mt-2"><?= $jumlah_buku; ?></p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Tabel Peminjaman -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-x-auto">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-[#0978B6] text-white">
          <tr>
            <th class="px-6 py-3 border">No</th>
            <?php if ($is_admin): ?>
              <th class="px-6 py-3 border">Nama</th>
            <?php endif; ?>
            <th class="px-6 py-3 border">Judul Buku</th>
            <th class="px-6 py-3 border">Tanggal Pinjam</th>
            <th class="px-6 py-3 border">Tanggal Kembali</th>
            <th class="px-6 py-3 border">Status</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php 
          $no = 1;
          if (mysqli_num_rows($peminjaman) > 0) {
            while ($row = mysqli_fetch_assoc($peminjaman)) : ?>
              <tr class="hover:bg-blue-50">
                <td class="px-6 py-3"><?= $no++; ?></td>
                <?php if ($is_admin): ?>
                  <td class="px-6 py-3"><?= htmlspecialchars($row['nama']); ?></td>
                <?php endif; ?>
                <td class="px-6 py-3"><?= htmlspecialchars($row['judul']); ?></td>
                <td class="px-6 py-3"><?= $row['tanggal_peminjaman']; ?></td>
                <td class="px-6 py-3"><?= $row['tanggal_pengembalian'] ?? '-'; ?></td>
                <td class="px-6 py-3 capitalize"><?= $row['status']; ?></td>
              </tr>
          <?php endwhile; 
          } else { ?>
            <tr><td colspan="<?= $is_admin ? 6 : 5 ?>" class="text-center py-4 text-gray-500">Tidak ada data peminjaman.</td></tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </main>

  <?php include '../includes/footer.php'; ?>
</body>
</html>
