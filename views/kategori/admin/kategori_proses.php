<?php
include '../../../includes/connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nama_kategori = trim($_POST['nama_kategori']);
    $jumlah_buku = intval($_POST['jumlah_buku']);
    $existing_cover = $_POST['existing_cover'] ?? '';

    // Validasi input kosong
    if (empty($nama_kategori)) {
        die("Nama kategori tidak boleh kosong.");
    }

    // Cek apakah nama kategori sudah ada (unik)
    $checkQuery = "SELECT id FROM kategori_buku WHERE nama_kategori = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "si", $nama_kategori, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        die("Kategori dengan nama ini sudah ada.");
    }
    mysqli_stmt_close($stmt);

    // Handle upload gambar
    $cover_path = $existing_cover;
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['cover'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('cover_') . '.' . $ext;
        $uploadDir = __DIR__ . '/../../../assets/images/kategori/';
        
        // Pastikan direktori ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $cover_path = '/sipermi/assets/images/kategori/' . $filename;
            
            // Hapus cover lama jika ada
            if (!empty($existing_cover)) {
                $oldPath = __DIR__ . '/../../..' . $existing_cover;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        }
    }

    // Jika ID ada, update. Jika tidak, insert baru
    if ($id > 0) {
        $query = "UPDATE kategori_buku SET nama_kategori = ?, jumlah_buku = ?, cover_path = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sisi", $nama_kategori, $jumlah_buku, $cover_path, $id);
    } else {
        $query = "INSERT INTO kategori_buku (nama_kategori, jumlah_buku, cover_path) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sis", $nama_kategori, $jumlah_buku, $cover_path);
    }

    // Eksekusi query insert/update
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        
        // Update book counts for all categories
        updateBookCounts($conn);
        
        header("Location: admin_kategori.php");
        exit;
    } else {
        mysqli_stmt_close($stmt);
        die("Gagal menyimpan data.");
    }
} else {
    die("Akses tidak sah.");
}

function updateBookCounts($conn) {
    $updateQuery = "UPDATE kategori_buku k
                    SET jumlah_buku = (
                        SELECT COUNT(*) 
                        FROM buku 
                        WHERE id_kategori = k.id
                    )";
    mysqli_query($conn, $updateQuery);
}