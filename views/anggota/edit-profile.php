<?php include_once '../../includes/header.php'; ?>

<div class="bg-gradient-to-br from-[#006298] via-[#0F9FEE] to-[#55B9F3] min-h-screen flex items-center justify-center p-6 font-sans">
  <form action="profile.php" method="POST" class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 text-gray-800 animate-fade-in space-y-4">
    <h2 class="text-2xl font-bold text-center mb-4">Edit Profil</h2>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
      <input type="text" name="nama" value="Ahmad Pratama" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
      <input type="email" name="email" value="ahmad@email.com" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">No. Telepon</label>
      <input type="text" name="telepon" value="0812-3456-7890" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label>
      <input type="text" name="alamat" value="Jl. Merdeka No.123" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
      <select name="status" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="Aktif" selected>Aktif</option>
        <option value="Nonaktif">Nonaktif</option>
      </select>
    </div>

    <div class="flex justify-center pt-4">
      <button type="submit" class="bg-gradient-to-r from-[#0F9FEE] to-[#55B9F3] hover:from-[#0c84cb] hover:to-[#49aee4] text-white px-6 py-2 rounded-full shadow-md transition duration-200">
        Simpan Perubahan
      </button>
    </div>
  </form>
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
