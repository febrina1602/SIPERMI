-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2025 at 02:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipermi`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor` varchar(20) DEFAULT NULL,
  `registered_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `role`, `nama`, `email`, `password`, `nomor`, `registered_at`) VALUES
(1, 'admin', 'Admin Perpus', 'admin@perpus.com', 'hashed_admin123', '081234567890', '2025-06-09 07:01:59'),
(2, 'user', 'Budi Santoso', 'budi@example.com', 'hashed_budi123', '089876543210', '2025-06-09 07:01:59'),
(3, 'user', 'Siti Aminah', 'siti@example.com', 'hashed_siti123', '088812345678', '2025-06-09 07:01:59'),
(4, 'user', 'febrina aulia azahra', 'febrina.auzahra2@gmail.com', '$2y$10$ek0qlNCwX9MvtgALtYZLM.mh0zqCnHci/qnHHQAsWJskSDNo76Zj2', '0895344533797', '2025-06-09 07:22:08'),
(5, 'admin', 'superadmin', 'admin.super@gmail.com', '$2y$10$llM8wRx.WbIlDbCx4C.Io.p4SmQbEpcMPO8l521tj0YWMD7hzXY3i', '0987654321', '2025-06-10 07:22:50');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` varchar(4) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `deskripsi` text,
  `stok` int DEFAULT '0',
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `isbn`, `id_kategori`, `deskripsi`, `stok`, `image_path`, `created_at`) VALUES
(1, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', '2005', '9789793062793', 1, 'Kisah perjuangan anak-anak di Belitung', 10, 'https://cf.shopee.sg/file/3e7d011eb27e85b3b7e6cfe5a72d80ce', '2025-06-09 07:01:59'),
(2, 'Atomic Habits', 'James Clear', 'Penguin Random House', '2018', '9780735211292', 2, 'Cara membentuk kebiasaan positif', 5, 'https://cdn2.penguin.com.au/covers/original/9781473565425.jpg', '2025-06-09 07:01:59'),
(3, 'Bumi', 'Tere Liye', 'Gramedia', '2014', '9786020324783', 3, 'Petualangan fantasi remaja bernama Raib', 7, 'https://cdn.gramedia.com/uploads/items/9786020332956_Bumi-New-Cover.jpg', '2025-06-09 07:01:59'),
(5, 'Harry Potter and the philosophers\'s stone', 'JK Rowling', ' London : Bloomsbury Publishing, 2014; © J.K. Rowling 1997', '2014', '09781408855652', 3, 'Turning the envelope over, his hand trembling, Harry saw a purple wax seal bearing a coat of arms; a lion, an eangle, a badger and a snake surrounding a large letter \'H\'. Harry Potter has never even heard of Hogwarts when the LETTERS start dropping on the doormat at number four, Privet Drive.', 1, '/sipermi/assets/images/buku/09781408855652_1749568398.jpg', '2025-06-10 08:13:18'),
(6, 'Ceros dan batozar', 'Tere Liye', 'Jakarta : Gramedia Pustaka Utama', '2018', ' 9786020385914', 3, 'Awalnya kami hanya mengikuti karyawisata biasa seperti murid-murid sekolah lain. Hingga Ali, dengan kegeniusan dan keisengannya, memutuskan menyelidiki sebuah ruangan kuno. Kami tiba di bagian dunia paralel lainnya, menemui petarung kuat, mendapat kekuatan baru serta teknik-teknik menakjubkan. Dunia paralel ternyata sangat luas, dengan begitu banyak orang hebat di dalamnya. Kisah ini tentang petualangan tiga sahabat. Raib bisa menghilang. Seli bisa mengeluarkan petir. Dan Ali bisa melakukan apa saja.', 2, '/sipermi/assets/images/buku/ 9786020385914_1749913856.jpg', '2025-06-14 15:10:56');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_buku`
--

CREATE TABLE `kategori_buku` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_buku`
--

INSERT INTO `kategori_buku` (`id`, `nama_kategori`) VALUES
(3, 'Fiksi'),
(1, 'Novel'),
(2, 'Self-Development');

ALTER TABLE `kategori_buku` ADD COLUMN `jumlah_buku` INT DEFAULT 0;
ALTER TABLE kategori_buku ADD COLUMN cover_path VARCHAR(255) DEFAULT NULL AFTER jumlah_buku;

UPDATE kategori_buku k
SET jumlah_buku = (
    SELECT COUNT(*) 
    FROM buku 
    WHERE id_kategori = k.id
);

DELIMITER //
CREATE TRIGGER after_buku_insert
AFTER INSERT ON buku
FOR EACH ROW
BEGIN
    UPDATE kategori_buku
    SET jumlah_buku = (SELECT COUNT(*) FROM buku WHERE id_kategori = NEW.id_kategori)
    WHERE id = NEW.id_kategori;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER after_buku_update
AFTER UPDATE ON buku
FOR EACH ROW
BEGIN
    IF OLD.id_kategori != NEW.id_kategori THEN
        UPDATE kategori_buku
        SET jumlah_buku = (SELECT COUNT(*) FROM buku WHERE id_kategori = OLD.id_kategori)
        WHERE id = OLD.id_kategori;
        
        UPDATE kategori_buku
        SET jumlah_buku = (SELECT COUNT(*) FROM buku WHERE id_kategori = NEW.id_kategori)
        WHERE id = NEW.id_kategori;
    END IF;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER after_buku_delete
AFTER DELETE ON buku
FOR EACH ROW
BEGIN
    UPDATE kategori_buku
    SET jumlah_buku = (SELECT COUNT(*) FROM buku WHERE id_kategori = OLD.id_kategori)
    WHERE id = OLD.id_kategori;
END//
DELIMITER ;
-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `id_anggota` int NOT NULL,
  `id_buku` int NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_anggota`, `id_buku`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status`) VALUES
(1, 2, 1, '2025-05-01', '2025-05-10', 'dipinjam'),
(2, 3, 2, '2025-05-03', '2025-05-12', 'dikembalikan'),
(3, 2, 3, '2025-05-05', '2025-05-15', 'dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_buku`
--

CREATE TABLE `ulasan_buku` (
  `id` int NOT NULL,
  `id_buku` int NOT NULL,
  `id_anggota` int NOT NULL,
  `rating` int DEFAULT NULL,
  `komentar` text,
  `tanggal_ulasan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `ulasan_buku`
--

INSERT INTO `ulasan_buku` (`id`, `id_buku`, `id_anggota`, `rating`, `komentar`, `tanggal_ulasan`) VALUES
(2, 5, 5, 4, 'baguss', '2025-06-14 15:00:18'),
(4, 5, 4, 2, 'Ternyata bukunya bahasa enggres 😭😭😭', '2025-06-14 14:55:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori_buku`
--
ALTER TABLE `kategori_buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori_buku`
--
ALTER TABLE `kategori_buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_buku` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD CONSTRAINT `ulasan_buku_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`),
  ADD CONSTRAINT `ulasan_buku_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
