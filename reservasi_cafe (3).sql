-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 07:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservasi_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan`
--

CREATE TABLE `detail_pemesanan` (
  `id_detail_pemesanan` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `id_meja` int(11) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `nomer_meja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`id_meja`, `kapasitas`, `nomer_meja`) VALUES
(1, 2, 100),
(2, 3, 101),
(3, 4, 102);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `kategori` enum('Makanan','Minuman','Dessert','') NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `kategori`, `nama_menu`, `harga`, `gambar`) VALUES
(10, 'Makanan', 'Nasi Goreng', 10000, 'nasi goreng.jpg'),
(11, 'Makanan', 'Pasta', 16000, 'pasta.jpg'),
(12, 'Makanan', 'Steak', 35000, 'steak.jpg'),
(13, 'Makanan', 'Ramen', 20000, 'ramen.jpg'),
(14, 'Makanan', 'Ayam Geprek', 10000, 'ayam geprek.jpg'),
(15, 'Makanan', 'Ayam Goreng', 18000, 'ayam goreng.jpg'),
(20, 'Minuman', 'Buble Tea', 8000, 'buble tea.jpg'),
(21, 'Minuman', 'Cappuchino', 6000, 'cappucino.jpg'),
(22, 'Minuman', 'Es Teh', 4000, 'es teh.jpg'),
(23, 'Minuman', 'Chocolatos', 5000, 'chocolatos.jpg'),
(24, 'Minuman', 'Boba', 8000, 'Boba.jpg'),
(25, 'Minuman', 'Espresso', 10000, 'espresso.jpg'),
(30, 'Dessert', 'Chocolate Milk', 15000, 'coklat milk.jpg'),
(31, 'Dessert', 'Moci', 5000, 'moci.jpg'),
(32, 'Dessert', 'Ice Cream', 10000, 'ice cream.jpg'),
(33, 'Dessert', 'Kue Basah', 5000, 'kue basah.jpg'),
(34, 'Dessert', 'Puding', 8000, 'puding.jpg'),
(35, 'Dessert', 'Waffle', 9000, 'waffle.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode` int(11) NOT NULL,
  `nama_metode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id_metode`, `nama_metode`) VALUES
(1, 'cash'),
(2, 'Transfer'),
(3, 'E-Wallet');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_metode` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_menu`, `nama_menu`, `id_pengguna`, `nama_pengguna`, `jumlah`, `tanggal`, `id_metode`, `total_harga`) VALUES
(17, 11, '', 10, '', 1, '2024-11-27', 1, 0.00),
(18, 10, '', 10, '', 1, '2024-11-27', 1, 0.00),
(19, 35, '', 10, '', 1, '2024-11-27', 1, 0.00),
(20, 10, '', 10, '', 1, '2024-11-27', 1, 0.00),
(21, 11, '', 10, '', 1, '2024-11-27', 1, 0.00),
(22, 10, '', 10, '', 1, '2024-11-27', 1, 0.00),
(23, 11, '', 10, '', 1, '2024-11-27', 2, 0.00),
(24, 10, '', 10, '', 1, '2024-11-27', 2, 0.00),
(25, 11, '', 10, '', 1, '2024-11-27', 2, 16000.00),
(26, 12, '', 10, '', 1, '2024-11-27', 2, 35000.00),
(27, 11, '', 10, '', 1, '2024-11-27', 3, 16000.00),
(28, 13, '', 10, '', 1, '2024-11-27', 3, 20000.00),
(30, 13, '', 10, '', 1, '2024-11-27', 1, 20000.00),
(31, 14, '', 10, '', 3, '2024-11-27', 1, 30000.00),
(32, 10, '', 10, '', 1, '2024-11-27', 2, 10000.00),
(33, 13, '', 10, '', 1, '2024-11-27', 2, 20000.00),
(34, 15, '', 10, '', 1, '2024-11-27', 2, 18000.00),
(35, 24, '', 10, '', 1, '2024-11-27', 1, 8000.00),
(36, 31, '', 10, '', 1, '2024-11-27', 1, 5000.00),
(37, 11, '', 10, '', 1, '2024-11-27', 1, 16000.00),
(38, 10, '', 10, '', 1, '2024-11-27', 1, 10000.00),
(39, 11, '', 10, '', 1, '2024-11-27', 2, 16000.00),
(40, 12, '', 10, '', 1, '2024-11-27', 2, 35000.00),
(41, 11, '', 10, '', 1, '2024-11-27', 3, 16000.00),
(42, 30, '', 10, '', 1, '2024-11-27', 3, 15000.00),
(43, 10, '', 10, '', 1, '2024-11-27', 1, 10000.00),
(44, 11, '', 10, '', 1, '2024-11-27', 1, 16000.00),
(45, 11, '', 10, '', 1, '2024-11-28', 2, 16000.00),
(46, 12, '', 10, '', 1, '2024-11-28', 2, 35000.00),
(47, 13, '', 10, '', 1, '2024-11-28', 1, 20000.00),
(48, 15, '', 10, '', 1, '2024-11-28', 1, 18000.00),
(49, 11, '', 10, '', 2, '2024-11-28', 1, 32000.00),
(50, 20, '', 10, '', 2, '2024-11-28', 1, 16000.00),
(51, 10, '', 10, '', 2, '2024-11-28', 2, 20000.00),
(52, 22, '', 10, '', 2, '2024-11-28', 2, 8000.00),
(53, 12, '', 10, '', 1, '2024-11-28', 1, 35000.00),
(54, 20, '', 10, '', 1, '2024-11-28', 1, 8000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `email`, `password`) VALUES
(10, 'xiumin', '', '$2y$10$4LcbRkyCGjp4nInax2a48OEXAwuB0wP2G5.8wnIukHgZiHOgxTSd2');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_products` int(11) NOT NULL,
  `kategori` enum('makanan','minuman','dessert','') NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_products`, `kategori`, `gambar`) VALUES
(1, 'makanan', 'makanan.jpg'),
(2, 'minuman', 'minuman milk.png'),
(3, 'dessert', 'dessert.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `id_meja` int(11) NOT NULL,
  `id_waktu` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `jumlah_menu` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `waktu_akhir` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_pengguna`, `nama_pengguna`, `id_meja`, `id_waktu`, `tanggal`, `jumlah_orang`, `id_menu`, `metode_pembayaran`, `status`, `jumlah_menu`, `total_harga`, `waktu_akhir`) VALUES
(48, 0, 'xiumin', 2, 3, '2024-11-27', 3, 31, 'Transfer', 'pending', 3, 15000.00, NULL),
(67, 0, '', 3, 7, '2024-11-27', 4, 20, 'Transfer', 'pending', 4, 32000.00, NULL),
(75, 0, '', 1, 3, '2024-11-28', 2, 10, 'cash', 'pending', 2, 20000.00, '10:00:00'),
(76, 0, '', 2, 7, '2024-11-28', 3, 32, 'E-Wallet', 'pending', 3, 30000.00, '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_reservasi`
--

CREATE TABLE `waktu_reservasi` (
  `id_waktu` int(11) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_akhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waktu_reservasi`
--

INSERT INTO `waktu_reservasi` (`id_waktu`, `waktu_mulai`, `waktu_akhir`) VALUES
(3, '07:00:00', '00:00:00'),
(5, '09:00:00', '00:00:00'),
(6, '13:00:00', '00:00:00'),
(7, '18:00:00', '00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD PRIMARY KEY (`id_detail_pemesanan`),
  ADD KEY `detail_pemesanan_ibfk_1` (`id_pemesanan`),
  ADD KEY `detail_pemesanan_ibfk_2` (`id_menu`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `pemesanan_ibfk_1` (`id_metode`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_products`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `fk_pengguna_reservasi` (`id_pengguna`),
  ADD KEY `fk_meja_reservasi` (`id_meja`),
  ADD KEY `fk_waktu_reservasi` (`id_waktu`);

--
-- Indexes for table `waktu_reservasi`
--
ALTER TABLE `waktu_reservasi`
  ADD PRIMARY KEY (`id_waktu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  MODIFY `id_detail_pemesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id_metode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_products` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `waktu_reservasi`
--
ALTER TABLE `waktu_reservasi`
  MODIFY `id_waktu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD CONSTRAINT `detail_pemesanan_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`),
  ADD CONSTRAINT `detail_pemesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_metode`) REFERENCES `metode_pembayaran` (`id_metode`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `pemesanan_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `fk_meja_reservasi` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`),
  ADD CONSTRAINT `fk_waktu_reservasi` FOREIGN KEY (`id_waktu`) REFERENCES `waktu_reservasi` (`id_waktu`),
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
