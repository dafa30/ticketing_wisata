-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 03:56 AM
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
-- Database: `tiket_wisata`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemesanan_tiket`
--

CREATE TABLE `tb_pemesanan_tiket` (
  `id_pemesan` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `nomer_identitas` bigint(16) DEFAULT NULL,
  `no_hp` bigint(13) DEFAULT NULL,
  `tempat_wisata` varchar(50) DEFAULT NULL,
  `jadwal_keberangkatan` datetime DEFAULT NULL,
  `pengunjung_dewasa` int(4) DEFAULT NULL,
  `pengunjung_anakanak` int(4) DEFAULT NULL,
  `harga_tiket` int(16) DEFAULT NULL,
  `total_bayar` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_pemesanan_tiket`
--
ALTER TABLE `tb_pemesanan_tiket`
  ADD PRIMARY KEY (`id_pemesan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_pemesanan_tiket`
--
ALTER TABLE `tb_pemesanan_tiket`
  MODIFY `id_pemesan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
