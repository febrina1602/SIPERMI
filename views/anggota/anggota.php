<<<<<<< HEAD
=======
<?php include_once('../../includes/connection_db.php'); ?>
<?php
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM peminjaman WHERE id_anggota=$id");
    mysqli_query($conn, "DELETE FROM ulasan_buku WHERE id_anggota=$id");
    mysqli_query($conn, "DELETE FROM anggota WHERE id=$id");
    header("Location: anggota.php");
    exit;
}

include_once('../../includes/header.php');
?>

>>>>>>> 9df788f1eb49234943c7c7e92f5962ce2e141369
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Anggota - SIPERMI</title>
  <script src="https://cdn.tailwindcss.com"></script>
<<<<<<< HEAD
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body class="bg-gradient-to-r from-[#006298] to-[#55B9F3] min-h-screen font-sans text-white">

  <header class="py-5 text-center">
    <h1 class="text-3xl font-bold">Daftar Anggota Perpustakaan</h1>
  </header>

  <main class="max-w-6xl mx-auto mt-6 p-6 bg-white rounded-xl shadow-xl text-gray-800">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
      <input type="text" id="searchInput" placeholder="Cari nama/email..." class="w-full md:w-1/3 px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-[#006298] transition" />
      <div class="flex gap-2">
        <button class="btn-export-excel bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md transition">Export Excel</button>
=======
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body class="bg-gradient-to-r from-[#006298] to-[#55B9F3] min-h-screen font-sans text-white flex flex-col">

  <header class="py-5 text-center">
    <h1 class="text-3xl font-bold bg-gradient-to-r from-[#006298] to-[#55B9F3] bg-clip-text text-transparent">
  Daftar Anggota Perpustakaan
</h1>

  </header>

  <main class="flex-grow max-w-6xl mx-auto mt-6 p-6 bg-white rounded-xl shadow-xl text-gray-800">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
      <input type="text" id="searchInput" placeholder="Cari nama/email..."
        class="w-full md:w-1/3 px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-[#006298] transition" />
      <div class="flex gap-2">
>>>>>>> 9df788f1eb49234943c7c7e92f5962ce2e141369
        <button class="btn-export-pdf bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition">Export PDF</button>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md" id="anggotaTable">
        <thead class="bg-gradient-to-r from-[#006298] to-[#55B9F3] text-white">
          <tr>
            <th class="py-3 px-4 text-left">ID</th>
            <th class="py-3 px-4 text-left">Nama</th>
            <th class="py-3 px-4 text-left">Email</th>
            <th class="py-3 px-4 text-left">No. Telepon</th>
            <th class="py-3 px-4 text-left">Tanggal Daftar</th>
            <th class="py-3 px-4 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
<<<<<<< HEAD
          <tr class="border-t hover:bg-gray-50 transition">
            <td class="py-2 px-4">1</td>
            <td class="py-2 px-4">Ahmad Pratama</td>
            <td class="py-2 px-4">ahmad@email.com</td>
            <td class="py-2 px-4">081234567890</td>
            <td class="py-2 px-4">2025-06-10</td>
            <td class="py-2 px-4">
              <button class="hapusBtn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">Hapus</button>
            </td>
          </tr>
          <tr class="border-t hover:bg-gray-50 transition">
            <td class="py-2 px-4">2</td>
            <td class="py-2 px-4">Siti Aminah</td>
            <td class="py-2 px-4">siti@email.com</td>
            <td class="py-2 px-4">082345678901</td>
            <td class="py-2 px-4">2025-06-09</td>
            <td class="py-2 px-4">
              <button class="hapusBtn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">Hapus</button>
            </td>
          </tr>
=======
        <?php
          $query = "SELECT id, nama, email, nomor, registered_at FROM anggota ORDER BY id DESC";
          $result = mysqli_query($conn, $query);
          while ($row = mysqli_fetch_assoc($result)):
        ?>
          <tr class="border-t hover:bg-gray-50 transition">
            <td class="py-2 px-4"><?= $row['id'] ?></td>
            <td class="py-2 px-4"><?= htmlspecialchars($row['nama']) ?></td>
            <td class="py-2 px-4"><?= htmlspecialchars($row['email']) ?></td>
            <td class="py-2 px-4"><?= htmlspecialchars($row['nomor']) ?></td>
            <td class="py-2 px-4"><?= date("d-m-Y", strtotime($row['registered_at'])) ?></td>
            <td class="py-2 px-4 flex gap-2">
              <a href="edit_anggota.php?id=<?= $row['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>
              <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus anggota ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
>>>>>>> 9df788f1eb49234943c7c7e92f5962ce2e141369
        </tbody>
      </table>
    </div>
  </main>

  <script>
<<<<<<< HEAD
    document.querySelectorAll(".hapusBtn").forEach(button => {
      button.addEventListener("click", function () {
        if (confirm("Yakin ingin menghapus anggota ini?")) {
          this.closest("tr").remove();
        }
      });
    });

=======
>>>>>>> 9df788f1eb49234943c7c7e92f5962ce2e141369
    document.getElementById("searchInput").addEventListener("input", function () {
      const keyword = this.value.toLowerCase();
      const rows = document.querySelectorAll("#anggotaTable tbody tr");
      rows.forEach(row => {
        const nama = row.children[1].textContent.toLowerCase();
        const email = row.children[2].textContent.toLowerCase();
        row.style.display = (nama.includes(keyword) || email.includes(keyword)) ? "" : "none";
      });
    });

<<<<<<< HEAD
    document.querySelector(".btn-export-excel").addEventListener("click", function () {
      const table = document.getElementById("anggotaTable");
      const wb = XLSX.utils.table_to_book(table, { sheet: "Anggota" });
      XLSX.writeFile(wb, "daftar_anggota.xlsx");
    });

=======
>>>>>>> 9df788f1eb49234943c7c7e92f5962ce2e141369
    document.querySelector(".btn-export-pdf").addEventListener("click", async function () {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      const table = document.getElementById("anggotaTable");
      await html2canvas(table).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdfWidth = doc.internal.pageSize.getWidth();
        const imgProps = doc.getImageProperties(imgData);
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        doc.addImage(imgData, "PNG", 0, 10, pdfWidth, pdfHeight);
        doc.save("daftar_anggota.pdf");
      });
    });
  </script>
</body>
</html>
<<<<<<< HEAD
=======
<?php include_once('../../includes/footer.php'); ?>
>>>>>>> 9df788f1eb49234943c7c7e92f5962ce2e141369
