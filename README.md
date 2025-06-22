# SIPERMI - Sistem Informasi Perpustakaan Mini

## 📚 Deskripsi Proyek
**SIPERMI** adalah aplikasi berbasis web yang dirancang untuk membantu pengelolaan perpustakaan secara digital. Sistem ini memungkinkan **admin** untuk mengelola koleksi buku, kategori, dan peminjaman, sementara **anggota (user)** dapat melihat daftar buku, memberikan ulasan, serta meminjam buku. Aplikasi ini bertujuan mempermudah akses informasi buku dan pengelolaan inventaris perpustakaan secara lebih efisien, transparan, dan terstruktur.

![Beranda](/assets/images/readme/dashboard.png)
---

## 🎯 Fitur Utama

### 🔐 Autentikasi & Otorisasi
- **Registrasi dan Login anggota** dengan peran `admin` atau `user`
- Password disimpan dalam bentuk **hash** untuk keamanan
- Sistem otorisasi berdasarkan role pengguna

### 📚 Manajemen Buku (Admin)
- Tambah, edit, hapus data buku
- Mengelola gambar cover dan deskripsi buku
- Stok buku otomatis diperbarui saat peminjaman terjadi

### 🗂️ Kategori Buku
- Admin dapat tambah, edit, hapus kategori buku
- Terdapat **jumlah buku per kategori** yang diperbarui secara otomatis lewat trigger

### 🔄 Transaksi Peminjaman
- Anggota dapat meminjam buku
- Admin mencatat status peminjaman (`dipinjam`, `dikembalikan`)
- Riwayat peminjaman dapat ditampilkan per user

### 🌟 Ulasan Buku
- Anggota dapat memberi ulasan dan rating pada buku
- Komentar disimpan beserta tanggal ulasan


---

## 🧩 Struktur Tabel (MySQL)

1. **`anggota`**
   - Menyimpan data pengguna (admin/user)
   - Field: `id`, `nama`, `email`, `password`, `role`, `nomor`, `registered_at`

2. **`buku`**
   - Menyimpan informasi detail buku
   - Field: `id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `isbn`, `id_kategori`, `stok`, `deskripsi`, `image_path`, `created_at`

3. **`kategori_buku`**
   - Menyimpan kategori buku
   - Field: `id`, `nama_kategori`, `jumlah_buku`, `cover_path`

4. **`peminjaman`**
   - Mencatat transaksi peminjaman buku
   - Field: `id`, `id_anggota`, `id_buku`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status`

5. **`ulasan_buku`**
   - Menyimpan rating dan komentar dari anggota terhadap buku
   - Field: `id`, `id_buku`, `id_anggota`, `rating`, `komentar`, `tanggal_ulasan`

---

## ⚙️ Trigger yang Digunakan

- **`after_buku_insert`**  
  Setelah buku baru ditambahkan, sistem otomatis memperbarui `jumlah_buku` pada tabel `kategori_buku`.

- **`after_buku_update`**  
  Jika kategori buku berubah, sistem mengurangi jumlah pada kategori lama dan menambahkan ke kategori baru.

- **`after_buku_delete`**  
  Jika buku dihapus, jumlah buku pada kategori terkait dikurangi.

---

## 💻 Teknologi yang Digunakan

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP (Native/PHP procedural)
- **Database**: MySQL
- **Server**: Apache (XAMPP/Laragon/Hosting lokal)
- **Styling**: Tailwind CSS 

---

## 🚀 Cara Menjalankan Aplikasi

### 1. Clone atau Download Project
```bash
git clone https://github.com/nama_user/sipermi.git

### 2. Klik link di bawah ini
[SIPERMI Online](https://sipermi.free.nf)
