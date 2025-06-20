<?php
include_once('../../includes/connection_db.php');

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit;
}

// Proses tambah anggota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nomor = mysqli_real_escape_string($conn, $_POST['nomor']);
    $role = ($_POST['role'] === 'admin') ? 'admin' : 'user';
    $password_plain = $_POST['password'];
    $password = password_hash($password_plain, PASSWORD_DEFAULT); 

    $query = "INSERT INTO anggota (nama, email, nomor, password, role, registered_at)
              VALUES ('$nama', '$email', '$nomor', '$password', '$role', NOW())";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Anggota berhasil ditambahkan.";
        header("Location: anggota.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal menambahkan anggota.";
    }
}

include_once('../../includes/header.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<main class="flex-grow flex items-center justify-center p-6">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-[#045481] mb-6">Tambah Anggota Baru</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" name="nomor" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
            </div>

            <div class="mb-6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Role</label>
                <select name="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] outline-none">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
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
