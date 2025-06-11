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
      <h1 class="text-3xl font-bold text-center text-[#0978B6] mb-8">Tambah Peminjaman</h1>

      <form action="simpan_peminjaman.php" method="POST" class="space-y-6">
        <div>
          <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Anggota</label>
          <input type="text" name="nama" id="nama" required placeholder="Masukkan nama anggota"
                 class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] outline-none shadow-sm transition">
        </div>

        <div>
          <label for="judul" class="block text-sm font-semibold text-gray-700 mb-1">Judul Buku</label>
          <input type="text" name="judul" id="judul" required placeholder="Masukkan judul buku"
                 class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] outline-none shadow-sm transition">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="tgl_pinjam" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pinjam</label>
            <input type="date" name="tgl_pinjam" id="tgl_pinjam" required
                   class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] outline-none shadow-sm transition">
          </div>

          <div>
            <label for="tgl_kembali" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" id="tgl_kembali" required
                   class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] outline-none shadow-sm transition">
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

</body>
</html>
