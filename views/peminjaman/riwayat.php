<?php
session_start();
include '../../includes/connection_db.php';

$id_user = $_SESSION['user']['id'];
$is_admin = $_SESSION['user']['role'] === 'admin';

// Proses update status menjadi "dikembalikan"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kembalikan'])) {
  $id_peminjaman = intval($_POST['id_peminjaman']);
  $tanggal_kembali = date('Y-m-d');

  $update = mysqli_query($conn, 
    "UPDATE peminjaman 
     SET status = 'dikembalikan', tanggal_pengembalian = '$tanggal_kembali' 
     WHERE id = $id_peminjaman");

  // Hindari resubmission
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

// Ambil data peminjaman & pengembalian berdasarkan role
if ($is_admin) {
  $peminjaman = mysqli_query($conn, 
    "SELECT p.*, u.nama AS nama_user, b.judul AS judul_buku 
     FROM peminjaman p 
     JOIN anggota u ON p.id_anggota = u.id 
     JOIN buku b ON p.id_buku = b.id 
     WHERE p.status = 'dipinjam'");

  $pengembalian = mysqli_query($conn, 
    "SELECT p.*, u.nama AS nama_user, b.judul AS judul_buku 
     FROM peminjaman p 
     JOIN anggota u ON p.id_anggota = u.id 
     JOIN buku b ON p.id_buku = b.id 
     WHERE p.status = 'dikembalikan'");
} else {
  $peminjaman = mysqli_query($conn, 
    "SELECT p.*, b.judul AS judul_buku 
     FROM peminjaman p 
     JOIN buku b ON p.id_buku = b.id 
     WHERE p.id_anggota = $id_user AND p.status = 'dipinjam'");

  $pengembalian = mysqli_query($conn, 
    "SELECT p.*, b.judul AS judul_buku 
     FROM peminjaman p 
     JOIN buku b ON p.id_buku = b.id 
     WHERE p.id_anggota = $id_user AND p.status = 'dikembalikan'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Peminjaman</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">
  <?php include '../../includes/header.php'; ?>

  <main class="container mx-auto px-4 py-10 flex-grow">
    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">

      <h2 class="text-3xl font-bold text-[#0978B6] mb-8 text-center">
        Riwayat <?= $is_admin ? 'Peminjaman Pengguna' : 'Peminjaman Buku' ?>
      </h2>

      <!-- Tombol tab -->
      <div class="flex justify-center mb-6 space-x-4">
        <button id="tab-peminjaman" onclick="showTab('peminjaman')" class="px-5 py-2 rounded-full border border-[#0978B6] text-[#0978B6] font-semibold bg-white shadow transition-all duration-200 border-b-4 border-[#0978B6]">
          Peminjaman
        </button>
        <button id="tab-pengembalian" onclick="showTab('pengembalian')" class="px-5 py-2 rounded-full border text-gray-600 font-semibold hover:text-[#0978B6] bg-white transition-all duration-200">
          Pengembalian
        </button>
      </div>

      <!-- Tabel Peminjaman -->
      <div id="peminjaman" class="tab-content overflow-x-auto">
        <table class="w-full table-auto text-sm border text-center">
          <thead class="bg-[#0978B6] text-white">
            <tr>
              <th class="p-3 border">No</th>
              <?php if ($is_admin): ?><th class="p-3 border">Nama</th><?php endif; ?>
              <th class="p-3 border">Judul Buku</th>
              <th class="p-3 border">Tanggal Pinjam</th>
              <th class="p-3 border">Status / Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php $no = 1; while($row = mysqli_fetch_assoc($peminjaman)) : ?>
            <tr class="hover:bg-gray-50">
              <td class="border p-2"><?= $no++; ?></td>
              <?php if ($is_admin): ?><td class="border p-2"><?= htmlspecialchars($row['nama_user']); ?></td><?php endif; ?>
              <td class="border p-2"><?= htmlspecialchars($row['judul_buku']); ?></td>
              <td class="border p-2"><?= $row['tanggal_peminjaman']; ?></td>
              <td class="border p-2 capitalize">
                <?= $row['status']; ?>
                <?php if ($is_admin): ?>
                  <form method="POST" action="" onsubmit="return confirm('Tandai sebagai dikembalikan?')">
                    <input type="hidden" name="id_peminjaman" value="<?= $row['id']; ?>">
                    <button type="submit" name="kembalikan" class="ml-2 px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Kembalikan</button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <!-- Tabel Pengembalian -->
      <div id="pengembalian" class="tab-content hidden overflow-x-auto mt-8">
        <table class="w-full table-auto text-sm border text-center">
          <thead class="bg-[#0978B6] text-white">
            <tr>
              <th class="p-3 border">No</th>
              <?php if ($is_admin): ?><th class="p-3 border">Nama</th><?php endif; ?>
              <th class="p-3 border">Judul Buku</th>
              <th class="p-3 border">Tanggal Kembali</th>
              <th class="p-3 border">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php $no = 1; while($row = mysqli_fetch_assoc($pengembalian)) : ?>
            <tr class="hover:bg-gray-50">
              <td class="border p-2"><?= $no++; ?></td>
              <?php if ($is_admin): ?><td class="border p-2"><?= htmlspecialchars($row['nama_user']); ?></td><?php endif; ?>
              <td class="border p-2"><?= htmlspecialchars($row['judul_buku']); ?></td>
              <td class="border p-2"><?= $row['tanggal_pengembalian'] ?? '-'; ?></td>
              <td class="border p-2 capitalize"><?= $row['status']; ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </div>
  </main>

  <?php include '../../includes/footer.php'; ?>

  <script>
    function showTab(tab) {
      const tabs = ['peminjaman', 'pengembalian'];
      tabs.forEach(t => {
        document.getElementById(t).classList.add('hidden');
        const btn = document.getElementById('tab-' + t);
        btn.classList.remove('border-b-4', 'text-[#0978B6]', 'border-[#0978B6]');
        btn.classList.add('text-gray-600');
      });

      document.getElementById(tab).classList.remove('hidden');
      const activeBtn = document.getElementById('tab-' + tab);
      activeBtn.classList.add('border-b-4', 'border-[#0978B6]', 'text-[#0978B6]');
      activeBtn.classList.remove('text-gray-600');
    }
  </script>
</body>
</html>
