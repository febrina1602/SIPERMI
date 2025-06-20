<?php
session_start();
include_once('../../../includes/header.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../../../auth/login.php");
    exit;
}

$user = $_SESSION['user'];
$successMessage = '';
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>

<div class="w-full max-w-4xl mx-auto mt-10 mb-10 p-10 rounded-2xl shadow-xl bg-white/70 backdrop-blur-sm border border-white/30 relative overflow-hidden">
  <?php if (!empty($successMessage)): ?>
    <div id="overlay-blur" class="absolute inset-0 bg-white/30 backdrop-blur-[2px] z-40 rounded-2xl"></div>
    
    <div id="success-alert"
         class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-50 border border-green-400 text-green-900 px-6 py-4 rounded-xl shadow-xl z-50 flex items-center gap-3 text-center text-base font-semibold">
      <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      <?= htmlspecialchars($successMessage); ?>
    </div>

    <script>
      setTimeout(() => {
        const alertBox = document.getElementById('success-alert');
        const overlay = document.getElementById('overlay-blur');
        if (alertBox && overlay) {
          alertBox.style.opacity = '0';
          overlay.style.opacity = '0';
          setTimeout(() => {
            alertBox.remove();
            overlay.remove();
          }, 500);
        }
      }, 1500);
    </script>
  <?php endif; ?>

  <div class="absolute top-6 right-6 z-10">
    <a href="edit-profile.php" class="bg-[#0066A1] text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-900 transition">
      Edit Profil
    </a>
  </div>

  <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10 mt-4 z-10">
    
    <div class="flex-1 space-y-6 mt-4 lg:mt-0" style="color: #0066A1;">
      <div>
        <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
        <div class="w-full px-4 py-2 bg-white border border-blue-200 rounded-lg shadow-sm">
          <?= htmlspecialchars($user['nama']) ?>
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1">Email</label>
        <div class="w-full px-4 py-2 bg-white border border-blue-200 rounded-lg shadow-sm">
          <?= htmlspecialchars($user['email']) ?>
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1">Nomor Telepon</label>
        <div class="w-full px-4 py-2 bg-white border border-blue-200 rounded-lg shadow-sm">
          <?= htmlspecialchars($user['nomor']) ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('../../../includes/footer.php'); ?>
