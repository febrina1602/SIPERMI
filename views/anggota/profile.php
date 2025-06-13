<?php include_once '../../includes/header.php'; ?>

<div class="flex items-center justify-center min-h-[80vh] bg-gray-100 px-4">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 text-gray-800 animate-fade-in">
    <!-- Foto Profil -->
    <div class="flex flex-col items-center text-center">
      <div class="bg-gradient-to-br from-[#006298] via-[#0F9FEE] to-[#55B9F3] p-[3px] rounded-full mb-4">
        <img src="https://via.placeholder.com/120" alt="Foto Profil" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg"/>
      </div>
      <h2 class="text-2xl font-bold">Ahmad Pratama</h2>
      <p class="text-gray-500 text-sm">Anggota sejak: <span class="font-medium">10 Juni 2025</span></p>
    </div>

    <!-- Info Detail -->
    <div class="mt-6 space-y-4 text-sm">
      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-600 font-medium">Email</span>
        <span class="text-right">ahmad@email.com</span>
      </div>
      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-600 font-medium">No. Telepon</span>
        <span class="text-right">0812-3456-7890</span>
      </div>
      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-600 font-medium">Alamat</span>
        <span class="text-right">Jl. Merdeka No.123</span>
      </div>
      <div class="flex justify-between border-b pb-2">
        <span class="text-gray-600 font-medium">Status</span>
        <span class="text-green-600 font-semibold">Aktif</span>
      </div>
    </div>

    <!-- Tombol -->
    <div class="mt-6 flex justify-center">
      <a href="edit-profile.php" class="bg-gradient-to-r from-[#0F9FEE] to-[#55B9F3] hover:from-[#0c84cb] hover:to-[#49aee4] text-white px-6 py-2 rounded-full shadow-md transition duration-200">
        Edit Profil
      </a>
    </div>
  </div>
</div>

<style>
  .animate-fade-in {
    animation: fadeIn 0.6s ease-in-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<?php include_once '../../includes/footer.php'; ?>
