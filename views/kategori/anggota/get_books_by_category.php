<?php
// Perbaikan path koneksi database
include __DIR__ . '/../../../includes/connection_db.php'; // Path yang benar dengan __DIR__

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

if ($category_id <= 0) {
    die("Kategori tidak valid.");
}

// Query buku dalam kategori
$query = "SELECT id, judul, penulis, image_path 
          FROM buku 
          WHERE id_kategori = ? 
          LIMIT 6";

$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $category_id);
if (!mysqli_stmt_execute($stmt)) {
    die("Error executing statement: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    die("Error getting result: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    while ($buku = mysqli_fetch_assoc($result)) {
        // Gunakan placeholder jika tidak ada gambar
        $image_path = !empty($buku['image_path']) ? $buku['image_path'] : 'https://via.placeholder.com/300x400?text=No+Image';
        ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
          <div class="relative aspect-[3/4] bg-gray-200 mb-3">
            <img
              src="<?= htmlspecialchars($image_path) ?>"
              alt="<?= htmlspecialchars($buku['judul']) ?>"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <h3 class="font-bold text-gray-800 line-clamp-1"><?= htmlspecialchars($buku['judul']) ?></h3>
          <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($buku['penulis']) ?></p>
          <div class="flex justify-between items-center">
            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Tersedia</span>
            <a href="detail_buku.php?id=<?= $buku['id'] ?>" class="text-primary hover:text-secondary">
              <i class="ri-information-line text-lg"></i>
            </a>
          </div>
        </div>
        <?php
    }
} else {
    echo '<p class="col-span-3 text-center text-gray-500">Belum ada buku dalam kategori ini.</p>';
}

// Tutup statement
mysqli_stmt_close($stmt);
?>