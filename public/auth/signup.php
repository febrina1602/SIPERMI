<?php
include '../includes/connection_db.php';
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $nomor = mysqli_real_escape_string($conn, trim($_POST['nomor']));

    // Validasi data tidak kosong 
    if (empty($nama) || empty($email) || empty($_POST['password']) || empty($nomor)) {
        $_SESSION['error'] = "Semua field wajib diisi.";
        header("Location: signup.php");
        exit;
    }

    $checkQuery = "SELECT * FROM anggota WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $_SESSION['error'] = "Email sudah terdaftar.";
        header("Location: signup.php");
        exit;
    }

    $insertQuery = "INSERT INTO anggota (nama, email, password, nomor) 
                    VALUES ('$nama', '$email', '$password', '$nomor')";

    if (mysqli_query($conn, $insertQuery)) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data.";
        header("Location: signup.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e7f0fb] min-h-screen flex items-center justify-center px-4">
  <div class="flex flex-col-reverse md:flex-row bg-white shadow-2xl rounded-3xl overflow-hidden max-w-5xl w-full">


    <div class="md:w-1/2 flex items-center justify-center bg-[#045481] p-6">
      <img src="../assets/signup.jpg" alt="Sign up image"
           class="rounded-xl shadow-lg w-full h-full object-cover max-h-[500px]" />
    </div> 

    <div class="md:w-1/2 p-10">
      <h2 class="text-3xl font-bold text-[#045481] text-center mb-6">Selamat Datang di SIPERMI</h2>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="signup.php" class="space-y-4">
        <div>
          <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] focus:outline-none">
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] focus:outline-none">
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
          <input type="password" name="password" id="password" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] focus:outline-none">
        </div>

        <div>
          <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
          <input type="text" name="nomor" id="nomor" required
                 class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#045481] focus:outline-none">
        </div>

        <button type="submit"
                class="w-full bg-[#045481] hover:bg-[#033a5e] text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-300"> Daftar</button>
      </form>

      <p class="mt-6 text-center text-sm text-gray-600">Sudah memiliki akun?
        <a href="login.php" class="text-[#045481] hover:underline font-medium">Masuk</a>
      </p>
    </div>

  </div>
</body>
</html>
