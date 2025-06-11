<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Peminjaman Buku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

  <!--  HEADER -->
  <?php include '../../includes/header.php'; ?>

  <!-- MAIN CONTENT -->
  <main class="flex-grow container mx-auto px-4 py-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-2xl border border-gray-200">
      <h1 class="text-3xl font-bold text-center text-[#0978B6] mb-8">Formulir Peminjaman Buku</h1>

      <form action="simpan_peminjaman_user.php" method="POST" class="space-y-6">
        <!-- Nama -->
        <div>
          <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Anda</label>
          <input type="text" name="nama" id="nama" required
                 placeholder="Masukkan nama lengkap"
                 class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] shadow-sm outline-none">
        </div>

        <!-- Judul Buku -->
        <div>
          <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
          <input type="text" name="judul" id="judul" required
                 placeholder="Masukkan judul buku"
                 class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] shadow-sm outline-none">
        </div>

        <!-- Tanggal Pinjam & Kembali -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required
                   class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] shadow-sm outline-none">
          </div>
          <div>
            <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" id="tanggal_kembali" required
                   class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#0978B6] shadow-sm outline-none">
          </div>
        </div>

        <!-- Tombol -->
        <div class="text-right pt-4">
          <button type="submit"
                  class="bg-[#0978B6] hover:bg-[#08659c] text-white px-6 py-3 rounded-lg shadow-md transition font-semibold">
            Ajukan Peminjaman
          </button>
        </div>
      </form>
    </div>
  </main>

  <!-- FOOTER -->
  <?php include '../../includes/footer.php'; ?>

</body>
</html>
