<?php
session_start();
include '../includes/connection_db.php';

// 1. KEAMANAN: Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk halaman ini.";
    header("Location: collection.php");
    exit;
}

// 2. VALIDASI ID BUKU DARI URL
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $_SESSION['error'] = "Permintaan tidak valid. ID buku tidak ditemukan.";
    header("Location: collection.php");
    exit;
}
$book_id = $_GET['id'];

// 3. AMBIL DATA BUKU SAAT INI (DILAKUKAN DI AWAL)
// Ini membuat data $book tersedia untuk blok POST dan untuk mengisi form di bawah
$stmt_get = mysqli_prepare($conn, "SELECT * FROM buku WHERE id = ?");
mysqli_stmt_bind_param($stmt_get, "i", $book_id);
mysqli_stmt_execute($stmt_get);
$result = mysqli_stmt_get_result($stmt_get);
$book = mysqli_fetch_assoc($result);

// Jika buku dengan ID tersebut tidak ditemukan, hentikan skrip
if (!$book) {
    $_SESSION['error'] = "Buku dengan ID " . htmlspecialchars($book_id) . " tidak ditemukan.";
    header("Location: collection.php");
    exit;
}

// 4. PROSES UPDATE DATA (JIKA FORM DISUBMIT)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil semua data dari form
    $id_to_update = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $isbn = $_POST['isbn'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    
    // ======================================================================
    // == BLOK UPDATE GAMBAR DISESUAIKAN DENGAN LOGIKA ANDA
    // ======================================================================
    $image_path = $book['image_path']; // Defaultnya adalah path gambar yang lama

    // Cek jika ada file BARU yang diupload
    if (isset($_FILES['cover_buku']) && $_FILES['cover_buku']['error'] === UPLOAD_ERR_OK) {
        
        // A. Hapus gambar lama (jika ada) dari server
        if (!empty($book['image_path'])) {
            // Gunakan metode parse_url dan DOCUMENT_ROOT sesuai contoh Anda
            $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . parse_url($book['image_path'], PHP_URL_PATH);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        // B. Proses upload gambar baru
        $image = $_FILES['cover_buku'];
        $uploadDir = '../assets/images/buku/'; // Path fisik relatif dari file skrip ini
        $fileName = $isbn . '_' . time() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Jika berhasil, perbarui variabel $image_path dengan path URL absolut yang baru
            // PENTING: Sesuaikan '/sipermi/' dengan nama folder proyek Anda jika berbeda
            $image_path = '/sipermi/assets/images/buku/' . $fileName;
        } else {
            $_SESSION['error'] = "Gagal memindahkan file baru.";
            header("Location: edit.php?id=" . $id_to_update);
            exit;
        }
    }
    // Jika tidak ada file baru yang diupload, variabel $image_path tidak akan diubah dan tetap berisi path lama.
    // ======================================================================
    // == AKHIR BLOK UPDATE GAMBAR
    // ======================================================================

    // 5. UPDATE DATA KE DATABASE (MENGGUNAKAN PREPARED STATEMENT YANG AMAN)
    $query_update = "UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ?, isbn = ?, id_kategori = ?, deskripsi = ?, stok = ?, image_path = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query_update);
    mysqli_stmt_bind_param($stmt, "sssssisssi", 
        $judul, $penulis, $penerbit, $tahun_terbit, $isbn, $id_kategori, $deskripsi, $stok, $image_path, $id_to_update
    );

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Data buku '" . htmlspecialchars($judul) . "' berhasil diperbarui.";
        header("Location: collection.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal memperbarui data buku: " . mysqli_stmt_error($stmt);
        header("Location: edit.php?id=" . $id_to_update);
        exit;
    }
}

// Ambil daftar kategori untuk dropdown (masih diperlukan untuk form)
$kategori_list = [];
$result_kategori = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori_buku ORDER BY nama_kategori ASC");
if ($result_kategori) {
    while ($row = mysqli_fetch_assoc($result_kategori)) {
        $kategori_list[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Buku - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

    <div class="container mx-auto max-w-3xl px-4 py-10">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
            
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-slate-800">Ubah Data Buku</h1>
                <a href="collection.php" class="text-sm font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Koleksi</a>
            </div>
            
            <form method="POST" action="edit.php" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                
                <div>
                    <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul Buku</label>
                    <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($book['judul']) ?>" class="w-full border-slate-300 p-3 rounded-lg" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="penulis" class="block text-sm font-medium text-slate-700 mb-1">Penulis</label>
                        <input type="text" id="penulis" name="penulis" value="<?= htmlspecialchars($book['penulis']) ?>" class="w-full border-slate-300 p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label for="penerbit" class="block text-sm font-medium text-slate-700 mb-1">Penerbit</label>
                        <input type="text" id="penerbit" name="penerbit" value="<?= htmlspecialchars($book['penerbit']) ?>" class="w-full border-slate-300 p-3 rounded-lg" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-medium text-slate-700 mb-1">Tahun Terbit</label>
                        <input type="number" id="tahun_terbit" name="tahun_terbit" value="<?= htmlspecialchars($book['tahun_terbit']) ?>" min="1000" max="<?= date('Y') ?>" class="w-full border-slate-300 p-3 rounded-lg" required>
                    </div>
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-slate-700 mb-1">ISBN</label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" class="w-full border-slate-300 p-3 rounded-lg" required>
                    </div>
                     <div>
                        <label for="stok" class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                        <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($book['stok']) ?>" min="0" class="w-full border-slate-300 p-3 rounded-lg" required>
                    </div>
                </div>

                <div>
                    <label for="id_kategori" class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select id="id_kategori" name="id_kategori" class="w-full border-slate-300 p-3 rounded-lg" required>
                        <option value="" disabled>-- Pilih Kategori --</option>
                        <?php foreach($kategori_list as $kategori): ?>
                            <?php $selected = ($kategori['id'] == $book['id_kategori']) ? 'selected' : ''; ?>
                            <option value="<?= $kategori['id'] ?>" <?= $selected ?>><?= htmlspecialchars($kategori['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full border-slate-300 p-3 rounded-lg"><?= htmlspecialchars($book['deskripsi']) ?></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Ganti Cover Buku (Opsional)</label>
                    <?php if(!empty($book['image_path'])): ?>
                    <div class="mb-4">
                        <p class="text-xs text-slate-500 mb-1">Cover saat ini:</p>
                        <img src="<?= htmlspecialchars($book['image_path']) ?>" alt="Cover saat ini" class="w-32 h-auto object-contain rounded border p-1">
                    </div>
                    <?php endif; ?>
                    
                    <div id="imagePreview" class="mb-4 hidden">
                         <p class="text-xs text-slate-500 mb-1">Pratinjau cover baru:</p>
                         <img id="preview" src="#" alt="Pratinjau Gambar" class="w-48 h-auto object-contain rounded-md border p-1" />
                    </div>
                    <label for="cover_buku" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition">
                         <input id="cover_buku" name="cover_buku" type="file" accept="image/*" class="hidden" onchange="previewImage(event)">
                         </label>
                </div>
                
                <div class="pt-4 border-t">
                    <button type="submit" class="w-full bg-[#0978B6] text-white font-bold py-3 px-4 rounded-lg shadow-md hover:bg-opacity-90 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
    // Script previewImage tetap sama
</script>
</body>
</html>