<?php
include '../../../includes/header.php';
include '../../../includes/connection_db.php';

// Ambil data kategori
$query = "
    SELECT id, nama_kategori
    FROM kategori_buku
    ORDER BY nama_kategori ASC
";

$result = mysqli_query($conn, $query);
$categories = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Kategori Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex flex-col">

  <div class="container mx-auto px-4 py-10 flex-grow">
    <h1 class="text-4xl font-bold mb-10 text-center text-blue-800 drop-shadow">📚 Manajemen Kategori Buku</h1>

    <div class="max-w-5xl mx-auto">
      <div class="flex justify-end mb-6">
       <button onclick="openAddModal()" class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] hover:from-[#044c79] hover:to-[#55a8db] text-white px-5 py-2 rounded-full shadow-lg transition-all duration-300 font-semibold text-sm flex items-center gap-2">
  <span class="text-white text-lg">+</span>
  Tambah Kategori
</button>



      </div>

      <div class="bg-white shadow-xl rounded-xl p-6">
        <table class="w-full text-sm md:text-base text-gray-700">
          <thead>
            <tr class="bg-blue-100 text-blue-800 border-b">
              <th class="py-3 px-4 text-left">ID</th>
              <th class="py-3 px-4 text-left">Nama Kategori</th>
              <th class="py-3 px-4 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $index => $category): ?>
            <tr class="border-b hover:bg-blue-50 transition">
              <td class="py-3 px-4"><?= $index + 1 ?></td>
              <td class="py-3 px-4"><?= htmlspecialchars($category['nama_kategori']) ?></td>
              <td class="py-3 px-4">
                <div class="flex gap-2">
                  <button onclick="openEditModal(<?= $category['id'] ?>, '<?= htmlspecialchars(addslashes($category['nama_kategori'])) ?>')" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow-sm">
                    ✏️ Edit
                  </button>
                  <button onclick="confirmDelete(<?= $category['id'] ?>)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow-sm">
                    🗑️ Hapus
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($categories)): ?>
              <tr>
                <td colspan="3" class="text-center py-6 text-gray-500 italic">Belum ada kategori.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Tambah/Edit -->
  <div id="kategoriModal" class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50 transition">
    <div class="bg-white rounded-2xl shadow-2xl w-96 p-8 animate-fade-in">
      <h2 id="modalTitle" class="text-2xl font-bold text-blue-700 text-center mb-6">Tambah Kategori</h2>
      <form id="kategoriForm" method="POST" action="kategori_proses.php">
        <input type="hidden" name="id" id="kategoriId">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
          <input type="text" name="nama_kategori" id="namaKategori" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div class="flex justify-end mt-6 gap-3">
          <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">Batal</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <footer class="mt-12">
    <?php include '../../../includes/footer.php'; ?>
  </footer>

  <script>
    function openAddModal() {
      document.getElementById('kategoriId').value = '';
      document.getElementById('namaKategori').value = '';
      document.getElementById('modalTitle').innerText = 'Tambah Kategori';
      document.getElementById('kategoriModal').classList.remove('hidden');
      document.getElementById('kategoriModal').classList.add('flex');
    }

    function openEditModal(id, nama) {
      document.getElementById('kategoriId').value = id;
      document.getElementById('namaKategori').value = nama;
      document.getElementById('modalTitle').innerText = 'Edit Kategori';
      document.getElementById('kategoriModal').classList.remove('hidden');
      document.getElementById('kategoriModal').classList.add('flex');
    }

    function closeModal() {
      document.getElementById('kategoriModal').classList.add('hidden');
      document.getElementById('kategoriModal').classList.remove('flex');
    }

    function confirmDelete(id) {
      if (confirm('Yakin ingin menghapus kategori ini?')) {
        window.location.href = 'kategori_hapus.php?id=' + id;
      }
    }
  </script>
</body>

</html>
