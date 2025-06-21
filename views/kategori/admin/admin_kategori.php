<?php
include '../../../includes/header.php';
include '../../../includes/connection_db.php';

// Ambil data kategori
$query = "
    SELECT id, nama_kategori, jumlah_buku, cover_path
    FROM kategori_buku
    ORDER BY id ASC
";

$result = mysqli_query($conn, $query);
$categories = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

// Handle ID resequencing
if (isset($_GET['resequence'])) {
    // Reset auto increment
    mysqli_query($conn, "ALTER TABLE kategori_buku AUTO_INCREMENT = 1");
    
    // Resequence IDs
    $updateQuery = "SET @count = 0;
                   UPDATE kategori_buku SET id = @count:= @count + 1;
                   ALTER TABLE kategori_buku AUTO_INCREMENT = 1;";
    
    mysqli_multi_query($conn, $updateQuery);
    
    // Refresh page
    header("Location: admin_kategori.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Kategori Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex flex-col">

<div class="container mx-auto px-4 py-10 flex-grow">
  <h1 class="text-4xl font-bold mb-10 text-center drop-shadow flex items-center justify-center gap-3">
    <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="Ikon Buku" class="w-12 h-12">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-500 to-pink-500">
      Manajemen Kategori Buku
    </span>
  </h1>
</div>


    <div class="max-w-5xl mx-auto">
      <div class="flex justify-between mb-6">
        <button onclick="openAddModal()" class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] hover:from-[#044c79] hover:to-[#55a8db] text-white px-5 py-2 rounded-full shadow-lg transition-all duration-300 font-semibold text-sm flex items-center gap-2">
          <i class="fas fa-plus-circle"></i> Tambah Kategori
        </button>
        
        <button onclick="resequenceIDs()" class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] hover:from-[#044c79] hover:to-[#55a8db] text-white px-5 py-2 rounded-full shadow-lg transition-all duration-300 font-semibold text-sm flex items-center gap-2">
          <i class="fas fa-sync-alt"></i> Reset Urutan ID
        </button>
      </div>

      <div class="bg-white shadow-xl rounded-xl p-6">
        <table class="w-full text-sm md:text-base text-gray-700">
          <thead>
            <tr class="bg-blue-100 text-blue-800 border-b">
              <th class="py-3 px-4 text-left">ID</th>
              <th class="py-3 px-4 text-left">Cover</th>
              <th class="py-3 px-4 text-left">Nama Kategori</th>
              <th class="py-3 px-4 text-left">Jumlah Buku</th>
              <th class="py-3 px-4 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $category): 
                // Escape khusus untuk JavaScript
                $escaped_nama = htmlspecialchars(addslashes($category['nama_kategori']));
                $escaped_cover = $category['cover_path'] ? htmlspecialchars(addslashes($category['cover_path'])) : '';
            ?>
            <tr class="border-b hover:bg-blue-50 transition">
              <td class="py-3 px-4 font-semibold"><?= $category['id'] ?></td>
              <!-- Di bagian tabel -->
              <td class="py-3 px-4">
                <?php if (!empty($category['cover_path'])): ?>
                  <div class="w-[80px] h-[120px] overflow-hidden rounded shadow">
                    <img src="<?= htmlspecialchars($category['cover_path']) ?>" alt="Cover Kategori" class="w-full h-full object-cover">
                  </div>
                <?php else: ?>
                  <div class="bg-gray-200 border-2 border-dashed rounded-xl w-[80px] h-[120px] flex items-center justify-center text-gray-400">
                    <i class="fas fa-image"></i>
                  </div>
                <?php endif; ?>
              </td>
              <td class="py-3 px-4"><?= htmlspecialchars($category['nama_kategori']) ?></td>
              <td class="py-3 px-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-medium">
                  <i class="fas fa-book mr-2"></i> <?= $category['jumlah_buku'] ?>
                </span>
              </td>
              <td class="py-3 px-4">
                <div class="flex gap-2">
                  <button onclick="openEditModal(<?= $category['id'] ?>, '<?= $escaped_nama ?>', <?= $category['jumlah_buku'] ?>, '<?= $escaped_cover ?>')" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow-sm">
                    <i class="fas fa-edit mr-1"></i> Edit
                  </button>
                  <button onclick="confirmDelete(<?= $category['id'] ?>)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow-sm">
                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($categories)): ?>
              <tr>
                <td colspan="5" class="text-center py-6 text-gray-500 italic">
                  <i class="fas fa-book-open mr-2"></i> Belum ada kategori.
                </td>
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
      <h2 id="modalTitle" class="text-2xl font-bold text-blue-700 text-center mb-6">
        <i class="fas fa-bookmark mr-2"></i> <span id="titleText">Tambah Kategori</span>
      </h2>
      <form id="kategoriForm" method="POST" action="kategori_proses.php" enctype="multipart/form-data">
        <input type="hidden" name="id" id="kategoriId">
        <input type="hidden" name="existing_cover" id="existingCover">
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-heading mr-2"></i>Nama Kategori
          </label>
          <input type="text" name="nama_kategori" id="namaKategori" required 
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                 placeholder="Contoh: Novel, Komik, Sains">
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-image mr-2"></i>Cover Kategori (Opsional)
          </label>
          <div id="coverPreview" class="mb-2 w-[160px] h-[240px]">
            <!-- Preview akan muncul di sini -->
          </div>
          <input type="file" name="cover" id="coverInput" accept="image/*" class="w-full text-sm">
        </div>
        
        <!-- Informasi jumlah buku (hanya untuk mode edit) -->
        <div id="jumlahBukuInfo" class="mb-4 hidden">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-book mr-2"></i>Jumlah Buku dalam Kategori
          </label>
          <div class="px-4 py-2 bg-gray-100 rounded-md font-semibold text-blue-700">
            <span id="jumlahBukuValue">0</span> buku
          </div>
          <p class="text-xs text-gray-500 mt-1">
            *Jumlah buku akan otomatis diperbarui sesuai buku dalam kategori
          </p>
        </div>
        
        <div class="flex justify-end mt-6 gap-3">
          <button type="button" onclick="closeModal()" 
                  class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 transition">
            <i class="fas fa-times mr-1"></i> Batal
          </button>
          <button type="submit" 
                  class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow transition">
            <i class="fas fa-save mr-1"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  
    <?php include '../../../includes/footer.php'; ?>
  

  <script>
    function openAddModal() {
      document.getElementById('kategoriId').value = '';
      document.getElementById('namaKategori').value = '';
      document.getElementById('coverPreview').innerHTML = '';
      document.getElementById('existingCover').value = '';
      document.getElementById('titleText').innerText = 'Tambah Kategori';
      
      // Sembunyikan info jumlah buku
      document.getElementById('jumlahBukuInfo').classList.add('hidden');
      
      document.getElementById('kategoriModal').classList.remove('hidden');
      document.getElementById('kategoriModal').classList.add('flex');
    }

    function openEditModal(id, nama, jumlah, cover) {
      document.getElementById('kategoriId').value = id;
      document.getElementById('namaKategori').value = nama;
      document.getElementById('existingCover').value = cover;
      document.getElementById('titleText').innerText = 'Edit Kategori';
      
      // Tampilkan jumlah buku sebagai informasi
      document.getElementById('jumlahBukuValue').textContent = jumlah;
      document.getElementById('jumlahBukuInfo').classList.remove('hidden');
      
      // Tampilkan preview cover jika ada
      const preview = document.getElementById('coverPreview');
      preview.innerHTML = '';
      if (cover) {
        const img = document.createElement('img');
        img.src = cover;
        img.alt = 'Cover Kategori';
        img.className = 'w-24 h-24 object-cover rounded mb-2';
        preview.appendChild(img);
      }
      
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
    
    function resequenceIDs() {
      if (confirm('Reset urutan ID kategori? Semua ID akan diurutkan ulang mulai dari 1.')) {
        window.location.href = 'admin_kategori.php?resequence=true';
      }
    }
    
    // Preview gambar saat dipilih
    document.getElementById('coverInput').addEventListener('change', function(e) {
      const file = e.target.files[0];
      const preview = document.getElementById('coverPreview');
      preview.innerHTML = '';
      
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = 'Preview Cover';
          img.className = 'w-24 h-24 object-cover rounded mb-2';
          preview.appendChild(img);
        }
        reader.readAsDataURL(file);
      }
    });

    // Debugging: Tampilkan error di console jika ada
    window.addEventListener('error', function(e) {
      console.error('JavaScript Error:', e.message, 'in', e.filename, 'line', e.lineno);
    });
  </script>
</body>
</html>