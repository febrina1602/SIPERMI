<?php
session_start();
include_once('../../../includes/connection_db.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $id = $user['id'];

    $update = mysqli_query($conn, "UPDATE anggota SET nama='$nama', email='$email', nomor='$telepon' WHERE id=$id");

    if ($update) {
        $_SESSION['user']['nama'] = $nama;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['nomor'] = $telepon;
        $_SESSION['success'] = "Profil berhasil diperbarui.";
        header("Location: profile.php?success=1");

        exit;
    } else {
        $error_message = "Gagal mengupdate data.";
    }
}

$nama = $user['nama'];
$email = $user['email'];
$telepon = $user['nomor'];
?>

<?php include_once('../../../includes/header.php'); ?>

<div class="w-full max-w-4xl mx-auto mt-10 mb-10 p-10 rounded-2xl shadow-xl bg-white/70 backdrop-blur-sm border border-white/30 relative">

  <div class="absolute top-6 right-6">
    <button type="submit" form="editForm"
            class="bg-[#0066A1] text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-900 transition">
      Simpan
    </button>
  </div>

  <h2 class="text-2xl font-bold text-[#0066A1] mb-6 text-center">Edit Profil</h2>

  <?php if (!empty($error_message)): ?>
    <p class="text-red-500 text-center mb-4"><?= $error_message ?></p>
  <?php endif; ?>

  <form id="editForm" method="post">
    <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">
      <div class="flex-shrink-0">
        <img src="https://cdn-icons-png.flaticon.com/512/4476/4476490.png" alt="profil buku" 
             class="w-40 h-40 rounded-full border-4 border-blue-200 shadow-md bg-white p-2">
        <p class="text-center mt-2 text-sm italic" style="color: #0066A1;">Foto profil otomatis</p>
      </div>

      <div class="flex-1 space-y-6 mt-4 lg:mt-0 text-[#0066A1]">
        <div>
          <label class="block text-sm font-semibold">Nama Lengkap</label>
          <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>"
                 class="mt-1 w-full px-4 py-2 border border-blue-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

        <div>
          <label class="block text-sm font-semibold">Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"
                 class="mt-1 w-full px-4 py-2 border border-blue-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

        <div>
          <label class="block text-sm font-semibold">Nomor Telepon</label>
          <input type="text" name="telepon" value="<?= htmlspecialchars($telepon) ?>"
                 class="mt-1 w-full px-4 py-2 border border-blue-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>
      </div>
    </div>
  </form>
</div>

<?php include_once('../../../includes/footer.php'); ?>
