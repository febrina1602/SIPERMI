<?php
session_start();
include '../../includes/connection_db.php'; 

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    $_SESSION['error'] = "Anda tidak memiliki hak akses untuk halaman ini.";
    header("Location: collection.php");
    exit;
}

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $_SESSION['error'] = "Permintaan tidak valid. ID buku tidak ditemukan.";
    header("Location: collection.php");
    exit;
}
$book_id = (int)$_GET['id'];

$stmt_get = mysqli_prepare($conn, "SELECT * FROM buku WHERE id = ?");
mysqli_stmt_bind_param($stmt_get, "i", $book_id);
mysqli_stmt_execute($stmt_get);
$result = mysqli_stmt_get_result($stmt_get);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    $_SESSION['error'] = "Buku dengan ID " . htmlspecialchars($book_id) . " tidak ditemukan.";
    header("Location: collection.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_to_update = (int)$_POST['id'];
    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun_terbit = trim($_POST['tahun_terbit']);
    $isbn = trim($_POST['isbn']);
    $id_kategori = (int)$_POST['id_kategori'];
    $deskripsi = trim($_POST['deskripsi']);
    $stok = (int)$_POST['stok'];
    $image_path = $book['image_path']; 

    if (!preg_match('/^\d{4}$/', $tahun_terbit) || $tahun_terbit > date("Y") || $tahun_terbit < 1000) {
        $_SESSION['error_flash'] = "Tahun terbit tidak valid (harus 4 digit dan tidak melebihi tahun sekarang).";
        header("Location: edit.php?id=$id_to_update");
        exit;
    }
    if (!preg_match('/^[\d-]{10,17}X?$/', $isbn)) {
        $_SESSION['error_flash'] = "Format ISBN tidak valid.";
        header("Location: edit.php?id=$id_to_update");
        exit;
    }

    if (isset($_FILES['cover_buku']) && $_FILES['cover_buku']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['cover_buku'];
        
        $allowed_types = ['image/jpeg', 'image/png'];
        $mime_type = mime_content_type($image['tmp_name']);
        if (!in_array($mime_type, $allowed_types)) {
            $_SESSION['error_flash'] = "File harus berupa gambar JPG atau PNG.";
            header("Location: edit.php?id=$id_to_update");
            exit;
        }

        if (!empty($book['image_path'])) {
            $old_filename = basename($book['image_path']);
            $old_physical_path = '../../assets/images/buku/' . $old_filename;
            if (file_exists($old_physical_path)) {
                unlink($old_physical_path);
            }
        }

        $uploadDir = '../../assets/images/buku/';
        $fileName = $isbn . '_' . time() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $image_path = '/sipermi/assets/images/buku/' . $fileName; 
        } else {
            $_SESSION['error_flash'] = "Gagal mengunggah file baru.";
            header("Location: edit.php?id=$id_to_update");
            exit;
        }
    }

    $query_update = "UPDATE buku SET judul = ?, penulis = ?, penerbit = ?, tahun_terbit = ?, isbn = ?, id_kategori = ?, deskripsi = ?, stok = ?, image_path = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $query_update);
    mysqli_stmt_bind_param($stmt_update, "sssssisssi", 
        $judul, $penulis, $penerbit, $tahun_terbit, $isbn, $id_kategori, $deskripsi, $stok, $image_path, $id_to_update
    );

    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['success'] = "Data buku '" . htmlspecialchars($judul) . "' berhasil diperbarui.";
        header("Location: collection.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal memperbarui data buku: " . mysqli_stmt_error($stmt_update);
        header("Location: edit.php?id=" . $id_to_update);
        exit;
    }
}

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
    <title>Ubah Data Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

    <div class="container mx-auto max-w-3xl px-4 py-10">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
            
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-slate-800">Ubah Data Buku</h1>
                <a href="../collection.php" class="text-sm font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Koleksi</a>
            </div>
            
            <?php if (isset($_SESSION['error_flash'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4" role="alert">
                    <?= $_SESSION['error_flash']; unset($_SESSION['error_flash']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="edit.php?id=<?= $book_id ?>" enctype="multipart/form-data" class="space-y-6">
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
                         <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm text-slate-500">Klik untuk ganti gambar</p>
                        </div>
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
        }
    }
</script>
</body>
</html>