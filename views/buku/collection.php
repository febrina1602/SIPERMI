<?php
include '../../includes/header.php';
include '../../includes/connection_db.php'; 

$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';

// Ambil parameter kategori dari URL
$currentCategoryId = isset($_GET['kategori']) ? intval($_GET['kategori']) : 0;
$currentCategoryName = '';

$query_kategori = "SELECT id, nama_kategori FROM kategori_buku ORDER BY nama_kategori ASC";
$result_kategori = mysqli_query($conn, $query_kategori);
$categories = [];
if ($result_kategori) {
    while ($row = mysqli_fetch_assoc($result_kategori)) {
        $categories[] = $row;
    }
}

// Query buku berdasarkan kategori jika ada parameter
if ($currentCategoryId) {
    // Dapatkan nama kategori untuk ditampilkan
    foreach ($categories as $cat) {
        if ($cat['id'] == $currentCategoryId) {
            $currentCategoryName = $cat['nama_kategori'];
            break;
        }
    }
    
    $query_buku = "SELECT b.id, b.judul, b.penulis, b.penerbit, b.stok, b.image_path, k.nama_kategori 
                   FROM buku AS b 
                   LEFT JOIN kategori_buku AS k ON b.id_kategori = k.id 
                   WHERE b.id_kategori = ?
                   ORDER BY b.created_at DESC";
    $stmt = mysqli_prepare($conn, $query_buku);
    mysqli_stmt_bind_param($stmt, "i", $currentCategoryId);
    mysqli_stmt_execute($stmt);
    $result_buku = mysqli_stmt_get_result($stmt);
} else {
    // Tampilkan semua buku jika tidak ada filter kategori
    $query_buku = "SELECT b.id, b.judul, b.penulis, b.penerbit, b.stok, b.image_path, k.nama_kategori 
                   FROM buku AS b 
                   LEFT JOIN kategori_buku AS k ON b.id_kategori = k.id 
                   ORDER BY b.created_at DESC";
    $result_buku = mysqli_query($conn, $query_buku);
}

$books = [];
if ($result_buku) {
    while ($row = mysqli_fetch_assoc($result_buku)) {
        $books[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <!-- ... Bagian head tetap sama ... -->
</head>
<body class="bg-slate-50">

    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        
        <header class="flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold text-slate-800">
                    <?php if ($currentCategoryId): ?>
                        Kategori: <?= htmlspecialchars($currentCategoryName) ?>
                    <?php else: ?>
                        Koleksi Buku
                    <?php endif; ?>
                </h1>
                <p class="mt-1 text-slate-500">
                    <?php if ($isAdmin): ?>
                        Kelola seluruh data buku dalam sistem.
                    <?php else: ?>
                        <?php if ($currentCategoryId): ?>
                            Buku-buku dalam kategori <?= htmlspecialchars($currentCategoryName) ?>
                        <?php else: ?>
                            Tingkatkan literasi membacamu hari ini!
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
            </div>
            
            <?php if ($isAdmin): ?>
            <div>
                <a href="add.php" class="inline-block bg-[#0978B6] text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-opacity-90 transition">
                    + Tambah Buku Baru
                </a>
            </div>
            <?php endif; ?>
        </header>

        <!-- Tambahkan navigasi kategori untuk non-admin -->
        <?php if (!$isAdmin && !$currentCategoryId): ?>
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-slate-700 mb-3">Telusuri Berdasarkan Kategori</h2>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($categories as $category): ?>
                    <a href="collection.php?kategori=<?= $category['id'] ?>" 
                       class="px-4 py-2 bg-white border border-slate-300 rounded-full text-sm hover:bg-slate-100 transition">
                        <?= htmlspecialchars($category['nama_kategori']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Tambahkan tombol kembali jika sedang melihat kategori tertentu -->
        <?php if (!$isAdmin && $currentCategoryId): ?>
        <div class="mt-4">
            <a href="collection.php" class="inline-flex items-center text-[#0978B6] hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Semua Buku
            </a>
        </div>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
        <!-- ... Tampilan admin tetap sama ... -->
        <?php else: ?>
        <!-- Tampilan pengguna biasa -->
        <main class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                <a href="detail.php?id=<?= $book["id"] ?>" class="card group block">
                    <div class="relative w-full aspect-[3/4] bg-slate-200 rounded-xl shadow-lg overflow-hidden">
                        <?php if (!empty($book['image_path'])): ?>
                            <img src="<?= htmlspecialchars($book['image_path']) ?>" alt="<?= htmlspecialchars($book['judul']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6-2.292m0 0a8.966 8.966 0 0 0-6 2.292m6-2.292a8.966 8.966 0 0 1 6 2.292m0 0V3.75c-1.053-.332-2.062-.512-3-.512a8.966 8.966 0 0 0-6 2.292"></path></svg>
                                <span class="text-xs mt-2">Cover tidak tersedia</span>
                            </div>
                        <?php endif; ?>
                        <div class="absolute inset-0 card-gradient flex flex-col justify-end p-4">
                            <span class="inline-block bg-slate-700/80 text-white text-xs font-semibold px-3 py-1 rounded-full self-start backdrop-blur-sm">
                                <?= htmlspecialchars($book['nama_kategori'] ?? 'Tanpa Kategori') ?>
                            </span>
                            <h3 class="text-white text-lg font-bold mt-2 leading-tight drop-shadow-md">
                                <?= htmlspecialchars($book['judul']) ?>
                            </h3>
                            <p class="text-slate-200 text-sm mt-1 truncate drop-shadow-md">
                                <?= htmlspecialchars($book['penulis']) ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-slate-900">Tidak ada buku</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        <?php if ($currentCategoryId): ?>
                            Belum ada buku dalam kategori ini.
                        <?php else: ?>
                            Belum ada buku yang tersedia.
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </main>
        <?php endif; ?>
    </div>
<?php include '../../includes/footer.php'; ?>
</body>
</html>