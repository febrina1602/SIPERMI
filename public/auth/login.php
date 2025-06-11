<?php
include '../../includes/connection_db.php';
session_start();
if (isset($_SESSION['user'])) {
    header("Location:../dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    $query = "SELECT * FROM anggota WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($pass, $user['password'])) {
            unset($user['password']); 
            $_SESSION['user'] = $user;
            header("Location:../dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah.";
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
    }

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - SIPERMI</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e7f0fb]">
  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-xl overflow-hidden max-w-5xl w-full">

      <div class="w-full md:w-1/2 p-10">
        <h2 class="text-2xl font-bold text-[#0978B6] mb-5">Silakan Masuk Sahabat SIPERMI</h2>
        <p class="text-sm text-gray-500 mb-8">Sistem Perpustakaan Mini</p>

        <form method="POST" action="login.php" class="space-y-5">
          <div>
            <label for="email" class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0978B6]" />
          </div>

          <div>
            <label for="password" class="block text-gray-700 mb-1">Kata Sandi</label>
            <input type="password" name="password" id="password" required
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0978B6]" />
          </div>

          <button type="submit" class="w-full bg-[#0978B6] hover:bg-[#06679b] text-white font-semibold py-2 rounded-md transition duration-200">Masuk</button>

          <p class="text-sm text-center text-gray-600">
            Belum punya akun?
            <a href="signup.php" class="text-[#0978B6] font-medium hover:underline">Daftar di sini</a>
          </p>
        </form>
      </div>

      <div class="hidden md:block md:w-1/2 bg-[#0978B6] p-6 flex items-center justify-center">
        <img src="../../assets/login.jpg" alt="Library Image"
          class="rounded-xl shadow-lg w-full h-full object-cover max-h-[500px]" />
      </div>

    </div>
  </div>
</body>
</html>
