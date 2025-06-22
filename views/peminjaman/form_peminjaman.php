<?php
include '../../includes/connection_db.php'; // koneksi ke DB
session_start();

$judul_buku = '';
$buku_id = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $buku_id = $_GET['id'];

    // Query ambil data buku berdasarkan ID
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

  <!-- Panggil HEADER -->
  <?php include '../../includes/header.php'; ?>

  <!-- MAIN CONTENT -->
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

        <!-- Kirim juga ID buku secara tersembunyi -->
        <input type="hidden" name="buku_id" value="<?= htmlspecialchars($buku_id); ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="tanggal_peminjaman" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pinjam</label>
            <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" required
                   class="w-full p-3 rounded-lg border border-gray-300 shadow-sm">
          </div>

          <div>
            <label for="tanggal_pengembalian" class="block text-sm font-semibold text-gray-700 mb-1">Maks. Tanggal Kembali</label>
            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" readonly
                   class="w-full p-3 rounded-lg border border-gray-300 shadow-sm bg-gray-100">
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

  <!-- Panggil FOOTER -->
  <?php include '../../includes/footer.php'; ?>

  <script>
    const tanggalPinjamInput = document.getElementById('tanggal_peminjaman');
    const tanggalKembaliInput = document.getElementById('tanggal_pengembalian');

    tanggalPinjamInput.addEventListener('change', function () {
      const tglPinjam = new Date(this.value);
      if (isNaN(tglPinjam)) return;

      // Tambah 7 hari
      tglPinjam.setDate(tglPinjam.getDate() + 7);

      // Format YYYY-MM-DD
      const yyyy = tglPinjam.getFullYear();
      const mm = String(tglPinjam.getMonth() + 1).padStart(2, '0');
      const dd = String(tglPinjam.getDate()).padStart(2, '0');
      const hasil = `${yyyy}-${mm}-${dd}`;

      tanggalKembaliInput.value = hasil;
    });
  </script>
</body>
</html>
