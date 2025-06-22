<?php
include '../../includes/connection_db.php';
session_start();

$judul_buku = '';
$buku_id = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $buku_id = $_GET['id'];
    $query = "SELECT judul FROM buku WHERE id = $buku_id LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $judul_buku = $data['judul'];
    } else {
        $judul_buku = 'Buku tidak ditemukan';
    }
} else {
    $judul_buku = 'ID buku tidak valid';
}

$today = date('Y-m-d');
$maxDate = date('Y-m-d', strtotime('+7 days'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Tambah Peminjaman</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

  <?php include '../../includes/header.php'; ?>

  <main class="flex-grow container mx-auto px-4 py-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
      <h1 class="text-3xl font-bold text-center text-[#0978B6] mb-8">Form Peminjaman Buku</h1>

      <form action="simpan_peminjaman.php" method="POST" class="space-y-6">
        <div>
          <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Anggota</label>
          <input type="text" id="nama" value="<?= htmlspecialchars($_SESSION['user']['nama'] ?? ''); ?>" disabled
                 class="w-full p-3 rounded-lg bg-gray-100 border border-gray-300 shadow-sm">
        </div>

        <div>
          <label for="judul" class="block text-sm font-semibold text-gray-700 mb-1">Judul Buku</label>
          <input type="text" name="judul" id="judul" value="<?= htmlspecialchars($judul_buku); ?>" readonly
                 class="w-full bg-gray-100 p-3 rounded-lg border border-gray-300 shadow-sm">
        </div>

        <input type="hidden" name="buku_id" value="<?= htmlspecialchars($buku_id); ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="tanggal_peminjaman" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pinjam</label>
            <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                   value="<?= $today; ?>" min="<?= $today; ?>" max="<?= $maxDate; ?>" required
                   class="w-full p-3 rounded-lg border border-gray-300 shadow-sm">
          </div>

          <div>
            <label for="tanggal_pengembalian" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kembali</label>
            <input type="text" id="tanggal_pengembalian" name="tanggal_pengembalian"
                   readonly class="w-full p-3 rounded-lg border border-gray-300 bg-gray-100 text-gray-800 font-medium">
          </div>
        </div>

        <div class="text-right">
          <button type="submit" class="bg-[#0978B6] hover:bg-[#08659c] text-white px-6 py-3 rounded-lg shadow-md transition font-semibold">
            Simpan Peminjaman
          </button>
        </div>
      </form>
    </div>
  </main>

  <?php include '../../includes/footer.php'; ?>

  <script>
    const pinjamInput = document.getElementById('tanggal_peminjaman');
    const kembaliInput = document.getElementById('tanggal_pengembalian');

    function updateTanggalKembali() {
      const tanggalPinjam = new Date(pinjamInput.value);
      if (!isNaN(tanggalPinjam)) {
        tanggalPinjam.setDate(tanggalPinjam.getDate() + 7);
        const yyyy = tanggalPinjam.getFullYear();
        const mm = String(tanggalPinjam.getMonth() + 1).padStart(2, '0');
        const dd = String(tanggalPinjam.getDate()).padStart(2, '0');
        kembaliInput.value = `${yyyy}-${mm}-${dd}`;
      } else {
        kembaliInput.value = '';
      }
    }

    pinjamInput.addEventListener('change', updateTanggalKembali);
    window.addEventListener('DOMContentLoaded', updateTanggalKembali);
  </script>

</body>
</html>
