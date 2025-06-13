<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user']);
$userRole = $isLoggedIn ? $_SESSION['user']['role'] : 'guest';
$userName = $isLoggedIn ? $_SESSION['user']['nama'] : 'Tamu';

$baseUrl = "http://localhost/sipermi/"; 

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIPERMI - Sistem Perpustakaan Mini</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
    <header class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] text-white p-4 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            
            <a href="<?= $baseUrl ?>dashboard.php" class="text-2xl font-bold">SIPERMI</a>

            <div class="hidden md:flex items-center gap-8">
                <nav>
                    <ul class="flex gap-6 text-sm">
                        <?php if ($userRole === 'admin'): ?>
                          <li><a href="<?= $baseUrl ?>views/buku/collection.php" class="transition-colors hover:text-slate-200">Kelola Buku</a></li>
                          <li><a href="<?= $baseUrl ?>views/kategori/kategori.php" class="transition-colors hover:text-slate-200">Kategori</a></li>
                          <li><a href="<?= $baseUrl ?>views/peminjaman/peminjaman.php" class="transition-colors hover:text-slate-200">Peminjaman</a></li>
                          <li><a href="<?= $baseUrl ?>views/anggota/anggota.php" class="transition-colors hover:text-slate-200">Anggota</a></li>
                          <li><a href="<?= $baseUrl ?>views/dashboard.php" class="transition-colors hover:text-slate-200">Dasbor</a></li>
                        
                        <?php elseif ($userRole === 'user'): ?>
                          <li><a href="<?= $baseUrl ?>views/buku/collection.php" class="transition-colors hover:text-slate-200">Koleksi Buku</a></li>
                          <li><a href="<?= $baseUrl ?>views/kategori/kategori.php" class="transition-colors hover:text-slate-200">Katalog Buku</a></li>
                          <li><a href="<?= $baseUrl ?>views/peminjaman/peminjaman.php" class="transition-colors hover:text-slate-200">Peminjaman</a></li>
                          <li><a href="<?= $baseUrl ?>views/anggota/anggota.php" class="transition-colors hover:text-slate-200">Profil</a></li>
                          <li><a href="<?= $baseUrl ?>views/dashboard.php" class="transition-colors hover:text-slate-200">Dasbor</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <div class="flex items-center gap-4">
                    <?php if ($isLoggedIn): ?>
                        <span class="text-sm border-l border-white/30 pl-6">Hi, <span class="font-semibold"><?= htmlspecialchars(explode(' ', $userName)[0]) ?></span>!</span>
                        <a href="<?= $baseUrl ?>public/auth/logout.php" class="bg-red-500 text-white text-sm font-semibold py-2 px-4 rounded-md hover:bg-red-600 transition-colors">Logout</a>
                    <?php else: ?>
                        <a href="<?= $baseUrl ?>public/auth/login.php" class="text-sm font-semibold hover:text-slate-200 transition-colors">Login</a>
                        <a href="<?= $baseUrl ?>public/auth/signup.php" class="bg-white text-[#0978B6] text-sm font-semibold py-2 px-4 rounded-md hover:bg-slate-100 transition-colors">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="md:hidden">
                <details class="relative">
                    <summary class="list-none cursor-pointer p-2 -mr-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </summary>
                    <div class="absolute right-0 mt-2 w-64 bg-white text-slate-800 rounded-lg shadow-xl p-4">
                        <ul class="flex flex-col gap-2">
                             <?php if ($userRole === 'admin'): ?>
                                <li><a href="<?= $baseUrl ?>views/buku/collection.php" class="transition-colors hover:text-slate-200">Kelola Buku</a></li>
                                <li><a href="<?= $baseUrl ?>views/kategori/kategori.php" class="transition-colors hover:text-slate-200">Kategori</a></li>
                                <li><a href="<?= $baseUrl ?>views/peminjaman/peminjaman.php" class="transition-colors hover:text-slate-200">Peminjaman</a></li>
                                <li><a href="<?= $baseUrl ?>views/anggota/anggota.php" class="transition-colors hover:text-slate-200">Anggota</a></li>
                                <li><a href="<?= $baseUrl ?>views/dashboard.php" class="transition-colors hover:text-slate-200">Dasbor</a></li>
                        
                            <?php elseif ($userRole === 'user'): ?>
                                <li><a href="<?= $baseUrl ?>views/buku/collection.php" class="transition-colors hover:text-slate-200">Koleksi Buku</a></li>
                                <li><a href="<?= $baseUrl ?>views/kategori/kategori.php" class="transition-colors hover:text-slate-200">Katalog Buku</a></li>
                                <li><a href="<?= $baseUrl ?>views/peminjaman/peminjaman.php" class="transition-colors hover:text-slate-200">Peminjaman</a></li>
                                <li><a href="<?= $baseUrl ?>views/anggota/anggota.php" class="transition-colors hover:text-slate-200">Profil</a></li>
                                <li><a href="<?= $baseUrl ?>views/dashboard.php" class="transition-colors hover:text-slate-200">Dasbor</a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="mt-4 pt-4 border-t border-slate-200 flex flex-col gap-3">
                            <?php if ($isLoggedIn): ?>
                                <div class="px-4">
                                    <p class="text-sm">Login sebagai:</p>
                                    <p class="font-semibold"><?= htmlspecialchars($userName) ?></p>
                                </div>
                                <a href="<?= $baseUrl ?>public/auth/logout.php" class="block w-full text-center bg-red-500 text-white text-sm font-semibold py-2 px-4 rounded-lg hover:bg-red-600 transition-colors">Logout</a>
                            <?php else: ?>
                                <a href="<?= $baseUrl ?>public/auth/login.php" class="block w-full text-center bg-[#0978B6] text-white text-sm font-semibold py-2 px-4 rounded-lg hover:bg-[#086a9f] transition-colors">Login</a>
                                <a href="<?= $baseUrl ?>public/auth/signup.php" class="block w-full text-center bg-slate-200 text-slate-800 text-sm font-semibold py-2 px-4 rounded-lg hover:bg-slate-300 transition-colors">Daftar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </details>
            </div>
        </div>
    </header>
</body>
</html>