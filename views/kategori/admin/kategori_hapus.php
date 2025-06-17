<?php
include '../../../includes/connection_db.php';

function updateBookCounts($conn) {
    $updateQuery = "UPDATE kategori_buku k
                    SET jumlah_buku = (
                        SELECT COUNT(*) 
                        FROM buku 
                        WHERE id_kategori = k.id
                    )";
    mysqli_query($conn, $updateQuery);
}

// Cek apakah ada parameter id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cek apakah ada buku yang terkait
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM buku WHERE id_kategori = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($total > 0) {
        die("Tidak dapat menghapus kategori karena masih ada buku yang terkait.");
    }

    // Jika aman, lakukan penghapusan
    $stmt_delete = mysqli_prepare($conn, "DELETE FROM kategori_buku WHERE id = ?");
    mysqli_stmt_bind_param($stmt_delete, "i", $id);

    if (mysqli_stmt_execute($stmt_delete)) {
        mysqli_stmt_close($stmt_delete);
        
        // Update jumlah buku semua kategori
        updateBookCounts($conn);
        
        // Resequence IDs
        $resequenceQuery = "SET @count = 0;
                           UPDATE kategori_buku SET id = @count:= @count + 1;
                           ALTER TABLE kategori_buku AUTO_INCREMENT = 1;";
        mysqli_multi_query($conn, $resequenceQuery);
        
        header("Location: admin_kategori.php");
        exit;
    } else {
        mysqli_stmt_close($stmt_delete);
        die("Gagal menghapus kategori.");
    }
} else {
    die("ID kategori tidak ditemukan.");
}
?>