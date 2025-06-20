<?php
include '../../../includes/header.php';
include '../../../includes/connection_db.php';

// Ambil semua kategori buku dari database
$query = "SELECT id, nama_kategori, jumlah_buku, cover_path FROM kategori_buku ORDER BY nama_kategori";
$result = mysqli_query($conn, $query);
$categories = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

// Fungsi untuk mendapatkan buku berdasarkan kategori
function getBooksByCategory($category_id) {
    global $conn;
    $query = "SELECT id, judul, penulis, image_path 
              FROM buku 
              WHERE id_kategori = ? 
              LIMIT 5";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $books = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    
    return $books;
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIPERMI - Sistem Perpustakaan Mini</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css"
    />
    <style>
      :where([class^="ri-"])::before { content: "\f3c2"; }
      .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      }
      .search-input:focus {
      border-color: #0077BE;
      box-shadow: 0 0 0 3px rgba(0, 119, 190, 0.2);
      }
      .footer-gradient {
      background: linear-gradient(135deg, #0077BE, #005a8e);
      }
      #bookDetailModal {
        transition: all 0.3s ease;
      }
    </style>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: { primary: "#0077BE", secondary: "#005a8e" },
            borderRadius: {
              none: "0px",
              sm: "4px",
              DEFAULT: "8px",
              md: "12px",
              lg: "16px",
              xl: "20px",
              "2xl": "24px",
              "3xl": "32px",
              full: "9999px",
              button: "8px",
            },
          },
        },
      };
    </script>
  </head>
  <body class="bg-gray-50 min-h-screen flex flex-col">

    
    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
      <!-- Page Title -->
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Semua Kategori</h1>
        <p class="text-gray-600">Temukan buku berdasarkan kategori favoritmu!</p>
      </div>
      <!-- Search Bar -->
      <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-grow">
          <div
            class="absolute inset-y-0 left-3 flex items-center pointer-events-none"
          >
            <i class="ri-search-line text-gray-400"></i>
          </div>
          <input
            type="text"
            id="searchInput"
            placeholder="Cari Kategori Buku"
            class="search-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none text-sm"
          />
        </div>
      </div>
      <!-- Categories Grid -->
      <div
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6"
        id="categoriesContainer"
      >
        <?php foreach ($categories as $category): ?>
          <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" 
               onclick="showBookDetails(<?= $category['id'] ?>, '<?= htmlspecialchars($category['nama_kategori']) ?>')">
            <div class="relative aspect-[2/3] bg-gray-200">
            <?php if (!empty($category['cover_path'])): ?>
              <img
                src="<?= htmlspecialchars($category['cover_path']) ?>"
                alt="<?= htmlspecialchars($category['nama_kategori']) ?>"
                class="w-full h-full object-cover"
              />
            <?php else: ?>
              <div class="w-full h-full flex items-center justify-center text-gray-400">
                <i class="ri-book-2-line text-5xl"></i>
              </div>
            <?php endif; ?>
          </div>
            <div class="p-4 text-center">
              <h3 class="font-bold text-gray-800"><?= htmlspecialchars($category['nama_kategori']) ?></h3>
              <p class="text-sm text-gray-500 mt-1"><?= $category['jumlah_buku'] ?> buku</p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
    </main>

    <!-- Book Detail Modal -->
    <div id="bookDetailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h2 id="modalCategoryTitle" class="text-2xl font-bold text-gray-800">Buku dalam Kategori: <span id="categoryName"></span></h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
              <i class="ri-close-line text-2xl"></i>
            </button>
          </div>
          
          <!-- Book List in Category -->
          <div id="bookListContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            <!-- Book list will be populated by JavaScript -->
          </div>
          
          <div class="mt-6 flex justify-center">
            <a id="allBooksLink" href="#" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-secondary">
              Lihat Semua Buku dalam Kategori Ini
            </a>
          </div>
        </div>
      </div>
    </div>

    <?php include '../../../includes/footer.php'; ?>

    <script>
      // Function to show book details modal
      function showBookDetails(categoryId, categoryName) {
        document.getElementById('categoryName').textContent = categoryName;
        document.getElementById('bookDetailModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Set link "Lihat Semua"
        document.getElementById('allBooksLink').href = 'buku.php?kategori=' + categoryId;
        
        // Load books for this category
        $.ajax({
          url: 'get_books_by_category.php',
          type: 'GET',
          data: { category_id: categoryId },
          success: function(response) {
            $('#bookListContainer').html(response);
          },
          error: function() {
            $('#bookListContainer').html('<p class="text-red-500">Gagal memuat data buku.</p>');
          }
        });
      }
      
      // Function to close modal
      function closeModal() {
        document.getElementById('bookDetailModal').classList.add('hidden');
        document.body.style.overflow = '';
      }
      
      // Close modal when clicking outside
      document.getElementById('bookDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
          closeModal();
        }
      });
      
      // Close modal with Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          closeModal();
        }
      });
      
      // Search functionality
      document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const categories = document.querySelectorAll('#categoriesContainer .category-card');
        
        categories.forEach(category => {
          const categoryName = category.querySelector('h3').textContent.toLowerCase();
          if (categoryName.includes(searchTerm)) {
            category.style.display = 'block';
          } else {
            category.style.display = 'none';
          }
        });
      });
    </script>
  </body>
</html>