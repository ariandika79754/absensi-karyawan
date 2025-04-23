-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jan 2025 pada 03.06
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectbnsp_ari`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(255) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Iphone'),
(2, 'Android');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id` int(255) NOT NULL,
  `nama_product` varchar(300) NOT NULL,
  `kategori_id` int(100) NOT NULL,
  `harga` varchar(200) NOT NULL,
  `stok` varchar(100) NOT NULL,
  `gambar` varchar(300) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id`, `nama_product`, `kategori_id`, `harga`, `stok`, `gambar`, `created_at`) VALUES
(1, 'Iphone 13 pro', 1, '15000000', '40', '1736560365_aa8ed66d0479b8118132.jpg', '2025-01-09 09:41:37'),
(2, 'Iphone 12', 1, '10000000', '11', '1736560323_9dc0c6b352939cc30a0d.jpg', '2025-01-11 08:52:03'),
(3, 'Samsung s20 Ultra', 2, '20000000', '100', '1736560437_f9ac6a5e4292aeab964f.jpg', '2025-01-11 08:53:57'),
(4, 'oppo reno 11', 2, '9000000', '100', '1736560471_863aab82cd6fd3d5027f.jpg', '2025-01-11 08:54:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Pelanggan'),
(3, 'Kps'),
(4, 'Dosen'),
(5, 'Staff'),
(6, 'Kajur'),
(7, 'Pudir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `kategori_id` int(100) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `jumlah_product` varchar(100) NOT NULL,
  `total_harga` varchar(100) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `product_id`, `kategori_id`, `harga`, `user_id`, `jumlah_product`, `total_harga`, `gambar`, `created_at`) VALUES
(8, '1', 0, '15000000', 1, '1', '15000000', '1736560365_aa8ed66d0479b8118132.jpg', '2025-01-05 18:27:50'),
(9, '1', 0, '15000000', 1, '1', '15000000', '1736560365_aa8ed66d0479b8118132.jpg', '2025-01-06 08:19:07'),
(10, '2', 0, '10000000', 1, '2', '20000000', '1736560323_9dc0c6b352939cc30a0d.jpg', '2025-01-06 08:20:08'),
(11, '1', 0, '15000000', 1, '2', '15000000', '1736560365_aa8ed66d0479b8118132.jpg', '2025-01-07 08:21:05'),
(12, '3', 0, '20000000', 1, '2', '40000000', '1736560437_f9ac6a5e4292aeab964f.jpg', '2025-01-07 08:21:20'),
(13, '1', 0, '15000000', 1, '1', '15000000', '1736560365_aa8ed66d0479b8118132.jpg', '2025-01-07 08:21:46'),
(14, '1', 0, '15000000', 1, '2', '15000000', '1736560365_aa8ed66d0479b8118132.jpg', '2025-01-08 08:33:14'),
(15, '1', 0, '15000000', 1, '2', '15000000', '1736560365_aa8ed66d0479b8118132.jpg', '2025-01-08 08:33:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `nama`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'ari', 'Ari Andika', '29e520fe9d18620e1bacd341f8263510f937e09479deebbbeab5ab758a659270', 2, '2025-01-09 10:00:58', '2025-01-09 10:00:58'),
(2, 'andika', 'ari', '29e520fe9d18620e1bacd341f8263510f937e09479deebbbeab5ab758a659270', 1, '2025-01-09 12:33:11', '2025-01-09 12:33:11');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`,`kategori_id`,`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
