<?php
session_start();
include '../../includes/connection_db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../../public/auth/login.php"); 
    exit;
}

$id_user = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];
$id_ulasan = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$book_id = isset($_GET['book']) ? (int) $_GET['book'] : 0;

$stmt = $conn->prepare("SELECT * FROM ulasan_buku WHERE id = ?");
$stmt->bind_param("i", $id_ulasan);
$stmt->execute();
$result = $stmt->get_result();
$ulasan = $result->fetch_assoc();

if (!$ulasan) {
    die("Ulasan tidak ditemukan.");
}

if ($ulasan['id_anggota'] != $id_user && $role != 'admin') {
    die("Akses ditolak.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int) $_POST['rating'];
    $komentar = trim($_POST['komentar']);

    if ($rating >= 1 && $rating <= 5 && !empty($komentar)) {
        $update = $conn->prepare("UPDATE ulasan_buku SET rating = ?, komentar = ?, tanggal_ulasan = NOW() WHERE id = ?");
        $update->bind_param("isi", $rating, $komentar, $id_ulasan);
        $update->execute();

        header("Location: detail.php?id=" . $book_id);
        exit;
    } else {
        $error = "Input tidak valid.";
    }
}

include '../../includes/header.php';
?>

<form method="post" class="max-w-xl mx-auto p-4 bg-white rounded shadow mt-8">
    <h2 class="text-xl font-bold mb-4">Edit Ulasan</h2>

    <?php if (isset($error)): ?>
        <p class="text-red-600"><?= $error ?></p>
    <?php endif; ?>

    <label class="block font-medium mb-1">Rating</label>
    <select name="rating" class="mb-4 w-full border p-2 rounded">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>" <?= $ulasan['rating'] == $i ? 'selected' : '' ?>><?= $i ?> ★</option>
        <?php endfor; ?>
    </select>

    <label class="block font-medium mb-1">Komentar</label>
    <textarea name="komentar" class="w-full border p-2 rounded mb-4" rows="4"><?= htmlspecialchars($ulasan['komentar']) ?></textarea>

    <div class="flex justify-between">
        <a href="detail.php?id=<?= $book_id ?>" class="text-gray-600 hover:underline">Batal</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </div>
</form>

<?php include '../../includes/footer.php'; ?>