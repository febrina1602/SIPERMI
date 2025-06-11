<?php
// Selalu mulai session di awal
session_start();

// Sertakan file koneksi database
include '../includes/connection_db.php'; 

// 1. PENGECEKAN ROLE ADMIN
// Variabel ini akan bernilai true jika user adalah admin, dan false jika tidak.
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';

// Query untuk mengambil semua kategori dari database
$query_kategori = "SELECT id, nama_kategori FROM kategori_buku ORDER BY nama_kategori ASC";
$result_kategori = mysqli_query($conn, $query_kategori);
$categories = [];
if ($result_kategori) {
    while ($row = mysqli_fetch_assoc($result_kategori)) {
        $categories[] = $row;
    }
}
$active_category_name = 'Novel';

$query_buku = "SELECT b.id, b.judul, b.penulis, b.penerbit, b.stok, b.image_path, k.nama_kategori FROM buku AS b LEFT JOIN kategori_buku AS k ON b.id_kategori = k.id ORDER BY b.created_at DESC";
$result_buku = mysqli_query($conn, $query_buku);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku - SIPERMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card-gradient { background-image: linear-gradient(to top, rgba(0,0,0,0.8), transparent 60%); }
    </style>
</head>
<body class="bg-slate-50">

    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        
        <header class="flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold text-slate-800">Koleksi Buku</h1>
                <p class="mt-1 text-slate-500">
                    <?php if ($isAdmin): ?>
                        Kelola seluruh data buku dalam sistem.
                    <?php else: ?>
                        Tingkatkan literasi membacamu hari ini!
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


        <?php if ($isAdmin): ?>
        
        <main class="mt-6">
            <div class="flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-slate-300">
                            <thead>
                                <tr class="bg-[#0978B6]">
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-3">Buku</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Kategori</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Penerbit</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Stok</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3 text-center text-sm font-semibold text-white">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php if (count($books) > 0): ?>
                                    <?php foreach ($books as $book): ?>
                                    <tr class="even:bg-slate-50 hover:bg-slate-100/75">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-3">
                                            <div class="flex items-center">
                                                <div class="h-16 w-12 flex-shrink-0">
                                                    <?php if (!empty($book['image_path'])): ?>
                                                        <img class="h-16 w-12 rounded-md object-cover" src="<?= htmlspecialchars($book['image_path']) ?>" alt="">
                                                    <?php else: ?>
                                                         <div class="h-16 w-12 rounded-md bg-slate-200 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6-2.292m0 0a8.966 8.966 0 0 0-6 2.292m6-2.292a8.966 8.966 0 0 1 6 2.292m0 0V3.75c-1.053-.332-2.062-.512-3-.512a8.966 8.966 0 0 0-6 2.292" /></svg>
                                                         </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ml-4">
                                                    <a href="detail.php?id=<?= $book['id'] ?>" class="font-medium text-slate-900 hover:text-indigo-600"><?= htmlspecialchars($book['judul']) ?></a>
                                                    <div class="text-slate-500"><?= htmlspecialchars($book['penulis']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500"><?= htmlspecialchars($book['nama_kategori'] ?? '-') ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500"><?= htmlspecialchars($book['penerbit']) ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <?php if($book['stok'] > 0): ?>
                                                <span class="font-semibold text-green-700"><?= $book['stok'] ?></span>
                                            <?php else: ?>
                                                <span class="font-semibold text-red-600">Habis</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-3">
                                            <a href="edit.php?id=<?= $book['id'] ?>" class="text-indigo-600 hover:text-indigo-900">✏️ Edit</a>
                                            <a href="delete.php?id=<?= $book['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus buku ini?')" class="text-red-600 hover:text-red-900 ml-4">🗑️ Hapus</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center py-10 text-slate-500">Belum ada buku di dalam database.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php else: ?>

        <main class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
        </main>
        
        <?php endif; ?>
        </div>

</body>
</html>