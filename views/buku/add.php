<?php
session_start();
// Path ../../ karena file ini ada di dalam folder admin
include '../includes/connection_db.php'; 

// 1. KEAMANAN: Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Jika bukan admin, tendang ke halaman koleksi
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk halaman ini.";
    header("Location: collection.php");
    exit;
}

// 2. AMBIL DATA KATEGORI: Untuk mengisi dropdown di form
$kategori_list = [];
$query_kategori = "SELECT id, nama_kategori FROM kategori_buku ORDER BY nama_kategori ASC";
$result_kategori = mysqli_query($conn, $query_kategori);
if ($result_kategori) {
    while ($row = mysqli_fetch_assoc($result_kategori)) {
        $kategori_list[] = $row;
    }
}

// 3. PROSES FORM JIKA DISUBMIT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil semua data dari form
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $isbn = $_POST['isbn'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $image_path = null; // Default value jika tidak ada gambar diupload

    // 4. PROSES UPLOAD GAMBAR
    $image_path = ''; // Default value
    // Cek jika ada file yang diupload dan tidak ada error
    if (isset($_FILES['cover_buku']) && $_FILES['cover_buku']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['cover_buku'];
        
        // 1. Tentukan folder tujuan sesuai permintaan Anda
        // Path ../ karena kita berada di dalam folder admin
        $uploadDir = '../assets/images/buku/';
        
        // 2. Buat nama file unik sesuai permintaan Anda (ISBN_timestamp.ext)
        $fileName = $isbn . '_' . time() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $targetFile = $uploadDir . $fileName;

        // Pastikan folder tujuan ada, jika tidak, buat folder tersebut
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // 3. Simpan path absolut sesuai permintaan Anda
            $image_path = '/sipermi/assets/images/buku/' . $fileName;
        } else {
             $_SESSION['error'] = "Gagal memindahkan file yang diupload.";
             // Biarkan $image_path kosong jika gagal
        }
    }
    // ======================================================================
    // == AKHIR BLOK UPLOAD GAMBAR
    // ======================================================================


    // INSERT DATA KE DATABASE (MENGGUNAKAN PREPARED STATEMENT YANG AMAN)
    $query_insert = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, isbn, id_kategori, deskripsi, stok, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query_insert);
    
    // Sesuaikan tipe data: s=string, i=integer, d=double, b=blob
    mysqli_stmt_bind_param($stmt, "sssssisss", 
        $judul, 
        $penulis, 
        $penerbit, 
        $tahun_terbit, 
        $isbn, 
        $id_kategori, // Menggunakan id_kategori, bukan nama kategori
        $deskripsi, 
        $stok, 
        $image_path
    );

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Buku '" . htmlspecialchars($judul) . "' berhasil ditambahkan.";
        header("Location: collection.php");
        exit;
    } else {
        // Cek jika error disebabkan oleh duplikasi ISBN
        if (mysqli_errno($conn) == 1062) {
            $_SESSION['error'] = "Gagal menambahkan buku. ISBN '" . htmlspecialchars($isbn) . "' sudah terdaftar.";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_stmt_error($stmt);
        }
        // Redirect kembali ke form tambah buku jika ada error
        header("Location: tambah_buku.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

    <div class="container mx-auto max-w-3xl px-4 py-10">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
            
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-slate-800">Tambah Buku Baru</h1>
                <a href="collection.php" class="text-sm font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Koleksi</a>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4" role="alert">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="judul" class="block text-sm font-medium text-slate-700 mb-1">Judul Buku</label>
                    <input type="text" id="judul" name="judul" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="penulis" class="block text-sm font-medium text-slate-700 mb-1">Penulis</label>
                        <input type="text" id="penulis" name="penulis" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label for="penerbit" class="block text-sm font-medium text-slate-700 mb-1">Penerbit</label>
                        <input type="text" id="penerbit" name="penerbit" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-medium text-slate-700 mb-1">Tahun Terbit</label>
                        <input type="number" id="tahun_terbit" name="tahun_terbit" min="1000" max="<?= date('Y') ?>" placeholder="e.g. 2024" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-slate-700 mb-1">ISBN</label>
                        <input type="text" id="isbn" name="isbn" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                     <div>
                        <label for="stok" class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                        <input type="number" id="stok" name="stok" min="0" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                </div>

                <div>
                    <label for="id_kategori" class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select id="id_kategori" name="id_kategori" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        <?php foreach($kategori_list as $kategori): ?>
                            <option value="<?= $kategori['id'] ?>"><?= htmlspecialchars($kategori['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cover Buku</label>
                    <div id="imagePreview" class="mb-4 hidden">
                         <img id="preview" src="#" alt="Pratinjau Gambar" class="w-48 h-auto object-contain rounded-md border border border-gray-300 p-1" />
                    </div>
                    <label for="cover_buku" class="flex flex-col items-center justify-center w-full h-32 border-2 border border-gray-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm text-slate-500"><span class="font-semibold">Klik untuk upload</span> atau seret file</p>
                            <p class="text-xs text-slate-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                        </div>
                        <input id="cover_buku" name="cover_buku" type="file" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </label>
                </div>
                
                <div class="pt-4 border-t">
                    <button type="submit" class="w-full bg-[#0978B6] text-white font-bold py-3 px-4 rounded-lg shadow-md hover:bg-opacity-90 transition-all">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
    // Fungsi untuk menampilkan preview gambar sebelum diupload
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
             preview.src = '#';
             previewContainer.classList.add('hidden');
        }
    }
</script>
</body>
</html>