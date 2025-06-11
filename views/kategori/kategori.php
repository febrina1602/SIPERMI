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
      .book-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }
      .category-pill:hover {
      background-color: #0077BE;
      color: white;
      }
      .search-input:focus {
      border-color: #0077BE;
      box-shadow: 0 0 0 3px rgba(0, 119, 190, 0.2);
      }
      .footer-gradient {
      background: linear-gradient(135deg, #0077BE, #005a8e);
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
        <div class="flex items-center space-x-4">
          <a href="#" class="hidden md:block hover:underline">Masuk</a>
          <a
            href="#"
            class="hidden md:block bg-white text-primary px-4 py-2 rounded-button font-medium whitespace-nowrap"
            >Daftar</a
          >
          <button class="md:hidden w-10 h-10 flex items-center justify-center">
            <i class="ri-menu-line ri-lg"></i>
          </button>
        </div>
      </div>
    </header>
    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
      <!-- Page Title -->
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Semua Buku</h1>
        <p class="text-gray-600">Tingkatkan literasi membacamu hari ini!</p>
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
            placeholder="Cari Judul/Pengarang/ISBN..."
            class="search-input w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none text-sm"
          />
        </div>
        
      </div>
      <!-- Categories -->
      <div class="flex flex-wrap gap-2 mb-8">
        <button
          class="category-pill px-4 py-2 bg-primary text-white rounded-full text-sm font-medium whitespace-nowrap"
        >
          Semua
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Administrasi
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Agama
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Ekonomi
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Ensiklopedia
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Fiksi
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Humor
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Inspirasi
        </button>
        <button
          class="category-pill px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap transition-colors"
        >
          Sejarah
        </button>
      </div>
      <!-- Books Grid -->
      <div
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6"
      >
        <!-- Book 1 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/Lupaendonesa.png"
              alt="Lupa endonesa"
              class="w-full h-full object-cover object-top"
            />
            
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">Lupa endonesa</h3>
            <p class="text-sm text-gray-600 mb-2">Sujiwo Tejo (Pengarang) ; Endah Suci Astuti (Penyunting) ; Nurjannah Intan (Penyunting)</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                >Tersedia</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 2 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/MenaklukanUjungDuniawi.png"
              alt="Menaklukan Ujung Duniawi"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">
              Menaklukan Ujung Duniawi
            </h3>
            <p class="text-sm text-gray-600 mb-2">Bayu Prasetyo</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full"
                >Dipinjam</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 3 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/TheAdventureOfMiniUnicorn.png"
              alt="The Adventure Of Mini Unicorn"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">
              The Adventure Of Mini Unicorn
            </h3>
            <p class="text-sm text-gray-600 mb-2">Anindita Permata</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                >Tersedia</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 4 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/TheHauntingOfHillHouse.png"
              alt="Haunting Shadow"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">
              The haunting of hill house
            </h3>
            <p class="text-sm text-gray-600 mb-2">Nadya Andwiani ; Dyah Agustine</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                >Tersedia</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 5 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/TafsirTeologiPembebasanAgama.png"
              alt="Tafsir Teologi Pembebasan Agama"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">
              Tafsir Teologi Pembebasan Agama
            </h3>
            <p class="text-sm text-gray-600 mb-2">Dr. Wahid S.Ag, M.A.</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                >Tersedia</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 6 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/KetawangakakdiSenayan.png"
              alt="Ketawa ngakak di Senayan : humor-humor anggota DPR"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">
              Ketawa ngakak di Senayan : humor-humor anggota DPR
            </h3>
            <p class="text-sm text-gray-600 mb-2">Baharuddin Aritonang</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full"
                >Segera Kembali</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 7 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/Bersengkarut.png"
              alt="Bersengkarut"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">Bersengkarut</h3>
            <p class="text-sm text-gray-600 mb-2">Ratih Kumala</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                >Tersedia</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 8 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/Kitabkencan.png"
              alt="Kitab kencan : 50 tanda kenapa kencan pertama lo gak usah lanjut"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">Kitab kencan : 50 tanda kenapa kencan pertama lo gak usah lanjut</h3>
            <p class="text-sm text-gray-600 mb-2">Sekar Ayu Asmara (Pengarang)</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full"
                >Dipinjam</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 9 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/ManajemenBisnisModern.png"
              alt="Manajemen Bisnis Modern"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">
              Manajemen Bisnis Modern
            </h3>
            <p class="text-sm text-gray-600 mb-2">Prof. Bambang Sutrisno</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                >Tersedia</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Book 10 -->
        <div
          class="book-card bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300"
          data-category="administrasi"
          data-isbn="9780123456789"
        >
          <div class="relative aspect-[3/4] bg-gray-200">
            <img
              src="../../assets/buku/KotaMasaDepan.png"
              alt="Kota Masa Depan"
              class="w-full h-full object-cover object-top"
            />
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 line-clamp-1">
              Kota Masa Depan
            </h3>
            <p class="text-sm text-gray-600 mb-2">Adinda Putri</p>
            <div class="flex justify-between items-center">
              <span
                class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full"
                >Tersedia</span
              >
              <button
                class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-full"
              >
                <i class="ri-bookmark-line"></i>
              </button>
            </div>
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
    <!-- Scripts -->
    <script id="bookmarkScript">
      document.addEventListener("DOMContentLoaded", function () {
        const bookmarkButtons = document.querySelectorAll(".book-card button");
        bookmarkButtons.forEach((button) => {
          button.addEventListener("click", function () {
            const icon = this.querySelector("i");
            if (icon.classList.contains("ri-bookmark-line")) {
              icon.classList.remove("ri-bookmark-line");
              icon.classList.add("ri-bookmark-fill");
              this.classList.add("text-yellow-500");
            } else {
              icon.classList.remove("ri-bookmark-fill");
              icon.classList.add("ri-bookmark-line");
              this.classList.remove("text-yellow-500");
            }
          });
        });
      });
    </script>
    <script id="categoryFilterScript">
      document.addEventListener("DOMContentLoaded", function () {
        const categoryPills = document.querySelectorAll(".category-pill");
        const bookCards = document.querySelectorAll(".book-card");
        categoryPills.forEach((pill) => {
          pill.addEventListener("click", function () {
            const category = this.textContent.trim().toLowerCase();
            categoryPills.forEach((p) => {
              p.classList.remove("bg-primary", "text-white");
              p.classList.add("bg-gray-100", "text-gray-700");
            });
            this.classList.remove("bg-gray-100", "text-gray-700");
            this.classList.add("bg-primary", "text-white");
            bookCards.forEach((card) => {
              const bookCategory = card.getAttribute("data-category").toLowerCase();
              if (category === "semua" || bookCategory === category) {
                card.style.display = "";
                card.classList.remove("hidden");
              } else {
                card.style.display = "none";
                card.classList.add("hidden");
              }
            });
          });
        });
      });
    </script>
    <script id="searchScript">
      document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.querySelector(".search-input");
        const filterButton = document.getElementById("filterButton");
        const filterModal = document.getElementById("filterModal");
        const closeFilter = document.getElementById("closeFilter");
        const bookCards = document.querySelectorAll(".book-card");
        searchInput.addEventListener("input", function () {
          const searchTerm = this.value.toLowerCase().trim();
          bookCards.forEach((card) => {
            const title = card.querySelector("h3").textContent.toLowerCase();
            const author = card.querySelector("p").textContent.toLowerCase();
            const isbn = card.getAttribute("data-isbn")?.toLowerCase() || "";
            if (
              title.includes(searchTerm) ||
              author.includes(searchTerm) ||
              isbn.includes(searchTerm)
            ) {
              card.style.display = "";
              card.classList.remove("hidden");
            } else {
              card.style.display = "none";
              card.classList.add("hidden");
            }
          });
        });
        searchInput.addEventListener("focus", function () {
          this.classList.add("ring-2", "ring-primary", "ring-opacity-50");
        });
        searchInput.addEventListener("blur", function () {
          this.classList.remove("ring-2", "ring-primary", "ring-opacity-50");
        });
        filterButton.addEventListener("click", function () {
          filterModal.classList.remove("hidden");
          document.body.style.overflow = "hidden";
        });
        closeFilter.addEventListener("click", function () {
          filterModal.classList.add("hidden");
          document.body.style.overflow = "";
        });
        filterModal.addEventListener("click", function (e) {
          if (e.target === filterModal) {
            filterModal.classList.add("hidden");
            document.body.style.overflow = "";
          }
        });
      });
    </script>
  </body>
</html>
