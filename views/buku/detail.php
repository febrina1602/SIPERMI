<?php
include '../includes/connection_db.php';

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $error_message = "Buku tidak ditemukan. ID tidak valid atau tidak disertakan.";
} else {
    $book_id = $_GET['id'];

    $query_buku = "
        SELECT 
            b.id, b.judul, b.penulis, b.penerbit, b.tahun_terbit,
            b.isbn, b.stok, b.deskripsi, b.image_path,
            k.nama_kategori
        FROM 
            buku AS b
        LEFT JOIN 
            kategori_buku AS k ON b.id_kategori = k.id
        WHERE 
            b.id = ?
        LIMIT 1
    ";
    
    $stmt = mysqli_prepare($conn, $query_buku);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Buku dengan ID " . htmlspecialchars($book_id) . " tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($book) ? htmlspecialchars($book['judul']) : 'Detail Buku'; ?> - SIPERMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-slate-50">

    <div class="container mx-auto max-w-5xl p-4 sm:p-6 lg:p-8">

    <?php if (isset($error_message)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
            <p class="font-bold">Error</p>
            <p><?= $error_message ?></p>
            <a href="collection.php" class="mt-4 inline-block bg-[#0978B6] text-white font-bold py-2 px-4 rounded hover:bg-opacity-90">
                &larr; Kembali ke Koleksi
            </a>
        </div>
    <?php elseif (isset($book)): ?>
        <a href="collection.php" class="text-[#0978B6] hover:underline mb-6 inline-block">&larr; Kembali ke Koleksi</a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-1">
                <div class="aspect-[3/4] bg-slate-200 rounded-lg shadow-lg flex items-center justify-center overflow-hidden">
                    <?php if (!empty($book['image_path'])): ?>
                        <img src="<?= htmlspecialchars($book['image_path']) ?>" alt="Cover <?= htmlspecialchars($book['judul']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6-2.292m0 0a8.966 8.966 0 0 0-6 2.292m6-2.292a8.966 8.966 0 0 1 6 2.292m0 0V3.75c-1.053-.332-2.062-.512-3-.512a8.966 8.966 0 0 0-6 2.292" /></svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="md:col-span-2">
                <h1 class="text-3xl lg:text-4xl font-bold text-slate-800"><?= htmlspecialchars($book['judul']) ?></h1>
                <p class="text-lg text-slate-500 mt-1"><?= htmlspecialchars($book['penulis']) ?> (Pengarang)</p>
                
                <?php if (!empty($book['nama_kategori'])): ?>
                <div class="mt-4">
                    <span class="inline-flex items-center gap-x-1.5 rounded-md bg-[#0978B6]/10 px-3 py-1 text-sm font-medium text-[#0978B6] ring-1 ring-inset ring-[#0978B6]/20">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.755a.75.75 0 0 1-.22.53l-1 1a.75.75 0 0 1 0 1.06l1 1a.75.75 0 0 1 .22.53v.755A1.5 1.5 0 0 0 2.5 11h.042a.75.75 0 0 1 .53.22l1 1a.75.75 0 0 1 .53.22H10a.75.75 0 0 1 .53-.22l1-1a.75.75 0 0 1 .53-.22h.042a1.5 1.5 0 0 0 1.5-1.5v-.755a.75.75 0 0 1 .22-.53l1-1a.75.75 0 0 1 0-1.06l-1-1a.75.75 0 0 1-.22-.53V4.5A1.5 1.5 0 0 0 13.542 3h-.042a.75.75 0 0 1-.53-.22l-1-1A.75.75 0 0 1 11 1.5H5a.75.75 0 0 1-.53.22l-1 1a.75.75 0 0 1-.53.22H2.5Z" clip-rule="evenodd" /></svg>
                        <?= htmlspecialchars($book['nama_kategori']) ?>
                    </span>
                </div>
                <?php endif; ?>

                
                <div class="mt-6 border-t pt-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Penerbit</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($book['penerbit']) ?>, <?= htmlspecialchars($book['tahun_terbit']) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($book['isbn']) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Stok Saat Ini</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold"><?= htmlspecialchars($book['stok']) ?></dd>
                        </div>
                    </dl>
                </div>
                
                <?php if (!empty($book['deskripsi'])): ?>
                <div class="mt-6 border-t pt-6">
                    <h2 class="text-lg font-semibold text-slate-800">Deskripsi</h2>
                    <div class="mt-2 text-slate-600 prose prose-sm max-w-none">
                        <?= nl2br(htmlspecialchars($book['deskripsi'])) ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="mt-6 flex flex-col sm:flex-row gap-4 items-start">
                    <div class="w-full sm:w-auto">
                        
                            <?php if ($book['stok'] > 0):  ?>
                                <a href="peminjaman/add.php?id=<?= $book['id'] ?>" class="w-full text-center inline-block bg-[#0978B6] text-white font-bold text-base py-2 px-6 rounded-lg shadow-md hover:bg-opacity-90 transition-colors">
                                    Pinjam Buku
                                </a>
                            <?php else:  ?>
                                <button disabled class="w-full text-center bg-slate-300 text-slate-500 font-bold text-base py-2 px-6 rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </button>
                            <?php endif; ?>
                        
                    </div>
                     <div class="w-full sm:w-auto text-center sm:text-left ">
                        <p class="text-sm font-medium text-slate-500">Ketersediaan:</p>
                        <?php if ($book['stok'] > 0): ?>
                             <p class="font-bold text-green-600">Tersedia</p>
                        <?php else: ?>
                             <p class="font-bold text-red-600">Dipinjam</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    <?php endif; ?>

    </div>

</body>
</html>