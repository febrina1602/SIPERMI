<?php include_once('../../includes/header.php'); ?>
<?php
include_once('../../includes/connection_db.php');

// Ambil ID anggota dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: anggota.php");
    exit;
}

$id = (int) $_GET['id'];

// Proses update setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nomor = mysqli_real_escape_string($conn, $_POST['nomor']);

    $updateQuery = "UPDATE anggota SET nama='$nama', email='$email', nomor='$nomor' WHERE id=$id";
    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['success'] = "Data berhasil diperbarui.";
        header("Location: anggota.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal memperbarui data.";
    }
}

// Ambil data anggota
$query = "SELECT * FROM anggota WHERE id=$id";
$result = mysqli_query($conn, $query);
$anggota = mysqli_fetch_assoc($result);

if (!$anggota) {
    header("Location: anggota.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Anggota</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
  <main class="flex-grow flex items-center justify-center p-6">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold text-center text-[#045481] mb-6">Edit Data Anggota</h2>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-4">
          <label class="block mb-1 text-sm font-medium text-gray-700">Nama</label>
          <input type="text" name="nama" value="<?= htmlspecialchars($anggota['nama']) ?>" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
        </div>

        <div class="mb-4">
          <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($anggota['email']) ?>" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
        </div>

        <div class="mb-6">
          <label class="block mb-1 text-sm font-medium text-gray-700">Nomor Telepon</label>
          <input type="text" name="nomor" value="<?= htmlspecialchars($anggota['nomor']) ?>" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
        </div>

        <div class="flex justify-between">
          <a href="anggota.php" class="text-gray-600 hover:underline">← Kembali</a>
          <button type="submit"
                  class="bg-[#045481] text-white px-6 py-2 rounded-md hover:bg-[#033a5e] transition">Simpan</button>
        </div>
      </form>
    </div>
  </main>
  <?php include_once('../../includes/footer.php'); ?>
</body>
</html>
