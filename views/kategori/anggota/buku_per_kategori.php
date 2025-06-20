<?php
include '../../../includes/connection_db.php';

// Ambil parameter kategori jika ada
$category_id = isset($_GET['kategori']) ? intval($_GET['kategori']) : 0;
$category_name = "Semua Buku";

// Query buku
if ($category_id > 0) {
    // Ambil nama kategori
    $query = "SELECT nama_kategori FROM kategori_buku WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($kategori = mysqli_fetch_assoc($result)) {
        $category_name = $kategori['nama_kategori'];
    }

    // Query buku dengan filter kategori
    $query = "SELECT * FROM buku WHERE id_kategori = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
} else {
    // Query semua buku
    $query = "SELECT * FROM buku";
    $stmt = mysqli_prepare($conn, $query);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$books = [];
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku | SIPERMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] text-white">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h2 class="text-2xl font-bold mb-2 drop-shadow-md">SIPERMI</h2>
            <nav class="hidden md:flex space-x-6">
                <a href="/SIPERMI/views/dashboard.php" class="py-2 hover:underline underline-offset-4">Beranda</a>
                <a href="#" class="py-2 font-medium underline underline-offset-4">Buku</a>
                <a href="kategori.php" class="py-2 hover:underline underline-offset-4">Kategori</a>
                <a href="#" class="py-2 hover:underline underline-offset-4">Anggota</a>
                <a href="#" class="py-2 hover:underline underline-offset-4">Peminjaman</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 flex-grow">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($category_name) ?></h1>
            <p class="text-gray-600 mt-2">
                <?php if ($category_id > 0): ?>
                    Menampilkan semua buku dalam kategori ini
                <?php else: ?>
                    Jelajahi koleksi buku perpustakaan kami
                <?php endif; ?>
            </p>
        </div>

        <?php if (count($books) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($books as $book): ?>
                    <div class="book-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300">
                        <div class="aspect-[2/3] bg-gray-200">
                            <?php if (!empty($book['image_path'])): ?>
                                <img 
                                    src="<?= htmlspecialchars($book['image_path']) ?>" 
                                    alt="<?= htmlspecialchars($book['judul']) ?>" 
                                    class="w-full h-full object-cover"
                                >
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-book text-5xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 truncate"><?= htmlspecialchars($book['judul']) ?></h3>
                            <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($book['penulis']) ?></p>
                            <p class="text-gray-500 text-xs mt-2">Tahun: <?= htmlspecialchars($book['tahun_terbit']) ?></p>
                            
                            <div class="mt-4">
                                <a 
                                    href="detail_buku.php?id=<?= $book['id'] ?>" 
                                    class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
                                >
                                    Detail Buku
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <i class="fas fa-book-open text-5xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700">
                    <?php if ($category_id > 0): ?>
                        Belum ada buku dalam kategori ini
                    <?php else: ?>
                        Belum ada buku di perpustakaan
                    <?php endif; ?>
                </h3>
                <p class="text-gray-600 mt-2">Silakan cek kembali nanti</p>
                <a href="kategori.php" class="mt-4 inline-block text-blue-600 hover:underline">
                    Lihat Kategori Buku
                </a>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] text-white">
        <div class="container mx-auto px-4 py-4">
            <div class="text-center mb-8">
                <h2 class="text-5xl font-bold mb-2 drop-shadow-md">SIPERMI</h2>
                <p class="text-gray-100">
                    Nikmati Kemudahan Akses Buku Hanya di Perpustakaan Mini
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-blue-400 pb-2">
                        Layanan
                    </h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="ri-search-line mr-2"></i>
                            <a href="#" class="hover:underline">Pencarian Buku</a>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-book-open-line mr-2"></i>
                            <a href="#" class="hover:underline"
                                >Peminjaman & Pengembalian</a
                            >
                        </li>
                        <li class="flex items-center">
                            <i class="ri-information-line mr-2"></i>
                            <a href="#" class="hover:underline">Lihat Status Buku</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-blue-400 pb-2">
                        Bantuan & Kebijakan
                    </h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="ri-question-line mr-2"></i>
                            <a href="#" class="hover:underline">Panduan Pengguna</a>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-shield-line mr-2"></i>
                            <a href="#" class="hover:underline">Kebijakan Privasi</a>
                        </li>
                        <li class="flex items-center">
                            <i class="ri-file-list-3-line mr-2"></i>
                            <a href="#" class="hover:underline">Tata Tertib Perpustakaan</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-blue-400 pb-2">
                        Ikuti Kami:
                    </h3>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30">
                            <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30">
                            <i class="ri-twitter-x-line"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30">
                            <i class="ri-youtube-line"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-blue-400 mt-8 pt-6 text-center text-sm">
                <p>© 2025 | SIPERMI. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>