<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Peminjaman</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Panggil HEADER -->
  <?php include '../../includes/header.php'; ?>

  <!-- MAIN CONTENT -->
  <main class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-xl font-semibold mb-4 text-[#0978B6]">Formulir Peminjaman Buku</h2>
      <form action="proses_peminjaman.php" method="POST" class="space-y-4">
        <div>
          <label for="anggota" class="block font-medium">Nama Anggota</label>
          <input type="text" id="anggota" name="anggota" class="w-full p-2 border rounded" placeholder="Masukkan nama anggota" required>
        </div>
        <div>
          <label for="judul" class="block font-medium">Judul Buku</label>
          <input type="text" id="judul" name="judul" class="w-full p-2 border rounded" placeholder="Masukkan judul buku" required>
        </div>
        <div>
          <label for="tanggalPinjam" class="block font-medium">Tanggal Peminjaman</label>
          <input type="date" id="tanggalPinjam" name="tanggal_pinjam" class="w-full p-2 border rounded" required>
        </div>
        <div>
          <label for="tanggalKembali" class="block font-medium">Tanggal Pengembalian</label>
          <input type="date" id="tanggalKembali" name="tanggal_kembali" class="w-full p-2 border rounded" required>
        </div>
        <div>
          <button type="submit" class="bg-[#0978B6] text-white px-4 py-2 rounded hover:bg-[#08659c]">
            Simpan Peminjaman
          </button>
        </div>
      </form>
    </div>

    <!-- Tabel Data Peminjaman -->
    <div class="bg-white p-6 mt-8 rounded-lg shadow-md">
      <h2 class="text-xl font-semibold mb-4 text-[#0978B6]">Daftar Peminjaman</h2>
      <table class="w-full table-auto border">
        <thead class="bg-[#0978B6] text-white">
          <tr>
            <th class="p-2 border">#</th>
            <th class="p-2 border">Nama Anggota</th>
            <th class="p-2 border">Judul Buku</th>
            <th class="p-2 border">Tanggal Pinjam</th>
            <th class="p-2 border">Tanggal Kembali</th>
            <th class="p-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $peminjaman = [
            ["id" => 1, "anggota" => "Dina Lestari", "judul" => "Belajar PHP", "tgl_pinjam" => "2025-06-01", "tgl_kembali" => "2025-06-08"],
            ["id" => 2, "anggota" => "Aldi Pratama", "judul" => "Logika Fuzzy", "tgl_pinjam" => "2025-06-03", "tgl_kembali" => "2025-06-10"]
          ];
          foreach ($peminjaman as $data) {
            echo "<tr class='text-center'>
                    <td class='border p-2'>{$data['id']}</td>
                    <td class='border p-2'>{$data['anggota']}</td>
                    <td class='border p-2'>{$data['judul']}</td>
                    <td class='border p-2'>{$data['tgl_pinjam']}</td>
                    <td class='border p-2'>{$data['tgl_kembali']}</td>
                    <td class='border p-2 space-x-2'>
                      <a href='#' class='bg-yellow-400 px-2 py-1 rounded text-white'>Edit</a>
                      <a href='#' class='bg-red-500 px-2 py-1 rounded text-white'>Hapus</a>
                    </td>
                  </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Panggil FOOTER -->
  <?php include '../../includes/footer.php'; ?>

</body>
</html>
