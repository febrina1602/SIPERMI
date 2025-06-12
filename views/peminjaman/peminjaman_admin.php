<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aktivitas Anggota</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">

  <!-- HEADER -->
  <?php include '../../includes/header.php'; ?>

  <!-- MAIN -->
  <main class="container mx-auto px-4 py-10 flex-grow">
    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">

      <!-- Judul -->
      <h2 class="text-3xl font-bold text-[#0978B6] mb-8 text-center">Daftar Riwayat Anggota</h2>

      <!-- Tabs -->
      <div class="flex justify-center mb-6 space-x-4">
        <button id="tab-peminjaman" onclick="showTab('peminjaman')" class="px-5 py-2 rounded-full border border-[#0978B6] text-[#0978B6] font-semibold bg-white shadow transition-all duration-200 border-b-4 border-[#0978B6]">
          Peminjaman
        </button>
        <button id="tab-pengembalian" onclick="showTab('pengembalian')" class="px-5 py-2 rounded-full border text-gray-600 font-semibold hover:text-[#0978B6] bg-white transition-all duration-200">
          Pengembalian
        </button>
      </div>

      <!-- Tombol tambah -->
      <div class="flex justify-end mb-4">
        <a href="form_peminjaman.php" class="inline-flex items-center bg-[#0978B6] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#08659c] transition-all duration-300 shadow">
          <span class="mr-2 text-lg">+</span> Tambah Peminjaman
        </a>
      </div>

      <!-- Tabel Peminjaman -->
      <div id="peminjaman" class="tab-content overflow-x-auto">
        <table class="w-full table-auto text-sm border text-center">
          <thead class="bg-[#0978B6] text-white">
            <tr>
              <th class="p-3 border">No</th>
              <th class="p-3 border">Nama Anggota</th>
              <th class="p-3 border">Judul Buku</th>
              <th class="p-3 border">Tanggal Pinjam</th>
              <th class="p-3 border">Tanggal Kembali</th>
              <th class="p-3 border">Status</th>
              <th class="p-3 border">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php
            $peminjaman = [
              ["id" => 1, "anggota" => "Raditya Andi", "judul" => "Laskar Pelangi", "tgl_pinjam" => "2025-06-02", "tgl_kembali" => "2025-06-09", "status" => "dipinjam"],
              ["id" => 2, "anggota" => "Indah Kurnia", "judul" => "Laskar Pelangi", "tgl_pinjam" => "2025-06-01", "tgl_kembali" => "2025-06-08", "status" => "dipinjam"],
              ["id" => 3, "anggota" => "Lutfi Riskia", "judul" => "Bumi", "tgl_pinjam" => "2025-05-05", "tgl_kembali" => "2025-05-15", "status" => "dipinjam"]
            ];
            foreach ($peminjaman as $data) {
              echo "<tr class='hover:bg-gray-50'>
                      <td class='border p-2'>{$data['id']}</td>
                      <td class='border p-2'>{$data['anggota']}</td>
                      <td class='border p-2'>{$data['judul']}</td>
                      <td class='border p-2'>{$data['tgl_pinjam']}</td>
                      <td class='border p-2'>{$data['tgl_kembali']}</td>
                      <td class='border p-2 capitalize'>{$data['status']}</td>
                      <td class='border p-2 space-x-2'>
                        <a href='#' class='bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm'>Edit</a>
                        <a href='#' class='bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm'>Hapus</a>
                      </td>
                    </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Tabel Pengembalian -->
      <div id="pengembalian" class="tab-content hidden overflow-x-auto">
        <table class="w-full table-auto text-sm border text-center">
          <thead class="bg-[#0978B6] text-white">
            <tr>
              <th class="p-3 border">No</th>
              <th class="p-3 border">Nama Anggota</th>
              <th class="p-3 border">Judul Buku</th>
              <th class="p-3 border">Tanggal Kembali</th>
              <th class="p-3 border">Status</th>
              <th class="p-3 border">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php
            $pengembalian = [
              ["id" => 1, "anggota" => "Andi", "judul" => "Filosofi Teras", "tgl_kembali" => "2025-06-10", "status" => "dikembalikan"],
              ["id" => 2, "anggota" => "Sari", "judul" => "Atomic Habits", "tgl_kembali" => "2025-06-11", "status" => "dikembalikan"]
            ];
            foreach ($pengembalian as $data) {
              echo "<tr class='hover:bg-gray-50'>
                      <td class='border p-2'>{$data['id']}</td>
                      <td class='border p-2'>{$data['anggota']}</td>
                      <td class='border p-2'>{$data['judul']}</td>
                      <td class='border p-2'>{$data['tgl_kembali']}</td>
                      <td class='border p-2 capitalize'>{$data['status']}</td>
                      <td class='border p-2 space-x-2'>
                        <a href='#' class='bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm'>Edit</a>
                        <a href='#' class='bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm'>Hapus</a>
                      </td>
                    </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <?php include '../../includes/footer.php'; ?>

  <!-- Script Tab -->
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
