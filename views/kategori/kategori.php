<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIPERMI - Sistem Perpustakaan Mini</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
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

    <!-- Header -->
    <header class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] text-white">
      <div
        class="container mx-auto px-4 py-3 flex justify-between items-center"
      >
        <h2 class="text-2xl font-bold mb-2 drop-shadow-md">SIPERMI</h2>
        
        <nav class="hidden md:flex space-x-6">
          <a href="#" class="py-2 hover:underline underline-offset-4"
            >Beranda</a
          >
          <a href="#" class="py-2 hover:underline underline-offset-4"
            >Buku</a
          >
          <a href="#" class="py-2 font-medium underline underline-offset-4"
            >Kategori Buku</a
          >
          <a href="#" class="py-2 hover:underline underline-offset-4"
            >Anggota</a
          >
          <a href="#" class="py-2 hover:underline underline-offset-4"
            >Peminjaman</a
          >
        </nav>
      </div>
    </header>
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
            placeholder="Cari Kategori Buku"
            class="search-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none text-sm"
          />
        </div>
      </div>
      <!-- Categories Grid -->
      <div
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6"
      >
        <!-- Category 1 - Fiksi -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Fiksi')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Fiksi"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Fiksi</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 2 - Non-Fiksi -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Non-Fiksi')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Non-Fiksi"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Non-Fiksi</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 3 - Sains -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Sains')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Sains"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Sains</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 4 - Teknologi -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Teknologi')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1535905557558-afc4877a26fc?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Teknologi"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Teknologi</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 5 - Sastra -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Sastra')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1541963463532-d68292c34b19?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Sastra"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Sastra</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 6 - Sejarah -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Sejarah')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Sejarah"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Sejarah</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 7 - Bisnis -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Bisnis')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Bisnis"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Bisnis</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 8 - Seni -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Seni')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Seni"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Seni</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 9 - Pendidikan -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Pendidikan')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1581726707445-75cbe4efc586?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Pendidikan"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Pendidikan</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
        
        <!-- Category 10 - Anak-anak -->
        <div class="category-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300" onclick="showBookDetails('Anak-anak')">
          <div class="relative aspect-square bg-gray-200">
            <img
              src="https://images.unsplash.com/photo-1532012197267-da84d127e765?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
              alt="Anak-anak"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-gray-800">Anak-anak</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat semua buku</p>
          </div>
        </div>
      </div>
      <!-- Pagination -->
      <div class="mt-10 flex justify-center">
        <nav class="flex items-center space-x-2">
          <button
            class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-500 hover:bg-gray-100"
          >
            <i class="ri-arrow-left-s-line"></i>
          </button>
          <button
            class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white"
          >
            1
          </button>
          <button
            class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100"
          >
            2
          </button>
          <button
            class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100"
          >
            3
          </button>
          <span class="px-2 text-gray-500">...</span>
          <button
            class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100"
          >
            8
          </button>
          <button
            class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-500 hover:bg-gray-100"
          >
            <i class="ri-arrow-right-s-line"></i>
          </button>
        </nav>
      </div>
    </main>

    <!-- Book Detail Modal -->
    <div id="bookDetailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h2 id="modalCategoryTitle" class="text-2xl font-bold text-gray-800">Buku dalam Kategori: <span id="categoryName">Fiksi</span></h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
              <i class="ri-close-line text-2xl"></i>
            </button>
          </div>
          
          <!-- Book List in Category -->
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            <!-- Book 1 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
              <div class="relative aspect-[3/4] bg-gray-200 mb-3">
                <img
                  src="../../assets/buku/Lupaendonesa.png"
                  alt="Lupa endonesa"
                  class="w-full h-full object-cover object-top"
                />
              </div>
              <h3 class="font-bold text-gray-800 line-clamp-1">Lupa endonesa</h3>
              <p class="text-sm text-gray-600 mb-2">Sujiwo Tejo</p>
              <div class="flex justify-between items-center">
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Tersedia</span>
                <button class="text-primary hover:text-secondary">
                  <i class="ri-information-line text-lg"></i>
                </button>
              </div>
            </div>
            
            <!-- Book 2 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
              <div class="relative aspect-[3/4] bg-gray-200 mb-3">
                <img
                  src="../../assets/buku/MenaklukanUjungDuniawi.png"
                  alt="Menaklukan Ujung Duniawi"
                  class="w-full h-full object-cover object-top"
                />
              </div>
              <h3 class="font-bold text-gray-800 line-clamp-1">Menaklukan Ujung Duniawi</h3>
              <p class="text-sm text-gray-600 mb-2">Bayu Prasetyo</p>
              <div class="flex justify-between items-center">
                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Dipinjam</span>
                <button class="text-primary hover:text-secondary">
                  <i class="ri-information-line text-lg"></i>
                </button>
              </div>
            </div>
            
            <!-- Book 3 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
              <div class="relative aspect-[3/4] bg-gray-200 mb-3">
                <img
                  src="../../assets/buku/TheAdventureOfMiniUnicorn.png"
                  alt="The Adventure Of Mini Unicorn"
                  class="w-full h-full object-cover object-top"
                />
              </div>
              <h3 class="font-bold text-gray-800 line-clamp-1">The Adventure Of Mini Unicorn</h3>
              <p class="text-sm text-gray-600 mb-2">Anindita Permata</p>
              <div class="flex justify-between items-center">
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Tersedia</span>
                <button class="text-primary hover:text-secondary">
                  <i class="ri-information-line text-lg"></i>
                </button>
              </div>
            </div>
            
            <!-- Book 4 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
              <div class="relative aspect-[3/4] bg-gray-200 mb-3">
                <img
                  src="../../assets/buku/TheHauntingOfHillHouse.png"
                  alt="Haunting Shadow"
                  class="w-full h-full object-cover object-top"
                />
              </div>
              <h3 class="font-bold text-gray-800 line-clamp-1">The haunting of hill house</h3>
              <p class="text-sm text-gray-600 mb-2">Nadya Andwiani</p>
              <div class="flex justify-between items-center">
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Tersedia</span>
                <button class="text-primary hover:text-secondary">
                  <i class="ri-information-line text-lg"></i>
                </button>
              </div>
            </div>
            
            <!-- Book 5 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
              <div class="relative aspect-[3/4] bg-gray-200 mb-3">
                <img
                  src="../../assets/buku/TafsirTeologiPembebasanAgama.png"
                  alt="Tafsir Teologi Pembebasan Agama"
                  class="w-full h-full object-cover object-top"
                />
              </div>
              <h3 class="font-bold text-gray-800 line-clamp-1">Tafsir Teologi Pembebasan Agama</h3>
              <p class="text-sm text-gray-600 mb-2">Dr. Wahid S.Ag, M.A.</p>
              <div class="flex justify-between items-center">
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Tersedia</span>
                <button class="text-primary hover:text-secondary">
                  <i class="ri-information-line text-lg"></i>
                </button>
              </div>
            </div>
          </div>
          
          <div class="mt-6 flex justify-center">
            <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-secondary">
              Lihat Semua Buku dalam Kategori Ini
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-[#055a8c] via-[#0978B6] to-[#66b3e6] text-white ">
      <div class="container mx-auto px-4 py-4">
        <div class="text-center mb-8">
          <h2 class="text-5xl font-bold mb-2 drop-shadow-md">SIPERMI</h2>
          <p class="text-gray-100">
            Nikmati Kemudahan Akses Buku Hanya di Perpustakaan Mini
          </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div>
            <h3
              class="text-lg font-semibold mb-4 border-b border-blue-400 pb-2"
            >
              Layanan
            </h3>
            <ul class="space-y-2">
              <li class="flex items-center">
                <i class="ri-search-line mr-2"></i>
                <a href="#" class="hover:underline">Pencarian Buku</a>
              </li>
              <li class="flex items-center">
                <i class="ri-book-open-line mr-2"></i>
                <a href="#" class="hover:underline"
                  >Peminjaman & Pengembalian</a
                >
              </li>
              <li class="flex items-center">
                <i class="ri-information-line mr-2"></i>
                <a href="#" class="hover:underline">Lihat Status Buku</a>
              </li>
            </ul>
          </div>
          <div>
            <h3
              class="text-lg font-semibold mb-4 border-b border-blue-400 pb-2"
            >
              Bantuan & Kebijakan
            </h3>
            <ul class="space-y-2">
              <li class="flex items-center">
                <i class="ri-question-line mr-2"></i>
                <a href="#" class="hover:underline">Panduan Pengguna</a>
              </li>
              <li class="flex items-center">
                <i class="ri-shield-line mr-2"></i>
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
              </li>
              <li class="flex items-center">
                <i class="ri-file-list-3-line mr-2"></i>
                <a href="#" class="hover:underline">Tata Tertib Perpustakaan</a>
              </li>
            </ul>
          </div>
          <div>
            <h3
              class="text-lg font-semibold mb-4 border-b border-blue-400 pb-2"
            >
              Ikuti Kami:
            </h3>
            <div class="flex space-x-4 mb-4">
              <a
                href="#"
                class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30"
              >
                <i class="ri-instagram-line"></i>
              </a>
              <a
                href="#"
                class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30"
              >
                <i class="ri-facebook-fill"></i>
              </a>
              <a
                href="#"
                class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30"
              >
                <i class="ri-twitter-x-line"></i>
              </a>
              <a
                href="#"
                class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30"
              >
                <i class="ri-youtube-line"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="border-t border-blue-400 mt-8 pt-6 text-center text-sm">
          <p>© 2025 | SIPERMI. Hak Cipta Dilindungi.</p>
        </div>
      </div>
    </footer>

    <script>
      // Function to show book details modal
      function showBookDetails(categoryName) {
        document.getElementById('categoryName').textContent = categoryName;
        document.getElementById('bookDetailModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
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
    </script>
  </body>
</html>