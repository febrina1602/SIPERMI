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
<body class="bg-gray-100 flex flex-col min-h-screen">

    <div class="container mx-auto py-7 flex-grow flex flex-col items-center">
        <h1 class="text-3xl font-bold mb-10 text-center text-blue-700">Manajemen Kategori Buku</h1>

        <div class="w-full max-w-4xl">
            <div class="flex justify-end mb-6">
                <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded shadow transition">+ Tambah Kategori</button>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <table class="min-w-full text-left text-gray-700">
                    <thead>
                        <tr class="border-b bg-blue-100">
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $index => $category): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4"><?= $index + 1 ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($category['nama_kategori']) ?></td>
                            <td class="py-3 px-4 flex gap-2">
                                <button onclick="openEditModal(<?= $category['id'] ?>, '<?= htmlspecialchars(addslashes($category['nama_kategori'])) ?>')" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                                <button onclick="confirmDelete(<?= $category['id'] ?>)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if (empty($categories)): ?>
                            <tr><td colspan="3" class="text-center py-6 text-gray-500">Belum ada kategori.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="kategoriModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 id="modalTitle" class="text-xl font-semibold mb-6 text-center text-blue-700">Tambah Kategori</h2>
            <form id="kategoriForm" method="POST" action="kategori_proses.php">
                <input type="hidden" name="id" id="kategoriId">
                <div class="mb-6">
                    <label class="block mb-2 font-medium text-gray-700">Nama Kategori:</label>
                    <input type="text" name="nama_kategori" id="namaKategori" required class="border border-gray-300 rounded px-4 py-2 w-full focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded mr-3">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

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

    <footer class="mt-auto">
        <?php include '../../../includes/footer.php'; ?>
    </footer>

</body>
</html>
