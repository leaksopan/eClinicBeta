-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 08:35 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eclinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id_antrian` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `no_antrian` VARCHAR(20) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_poliklinik` int(11) NOT NULL,
  `id_dokter` int(11) DEFAULT NULL,
  `status` enum('menunggu','diperiksa','selesai','batal') NOT NULL DEFAULT 'menunggu',
  `waktu_daftar` datetime NOT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `antrian`
--

INSERT INTO `antrian` (`id_antrian`, `tanggal`, `no_antrian`, `id_pasien`, `id_poliklinik`, `id_dokter`, `status`, `waktu_daftar`, `waktu_mulai`, `waktu_selesai`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '2025-03-21', 1, 1, 3, NULL, 'batal', '2025-03-21 08:48:35', NULL, NULL, '2025-03-21 08:48:35', 5, '2025-03-21 08:49:10', 5),
(2, '2025-03-21', 2, 1, 3, 4, 'diperiksa', '2025-03-21 08:52:35', '2025-03-21 09:23:19', NULL, '2025-03-21 08:52:35', 5, '2025-03-21 09:23:19', 5),
(3, '2025-03-25', 1, 1, 3, 4, 'batal', '2025-03-25 03:33:13', NULL, NULL, '2025-03-25 03:33:13', 5, '2025-03-25 03:33:58', 5),
(4, '2025-03-25', 1, 1, 5, 3, 'batal', '2025-03-25 04:31:23', NULL, NULL, '2025-03-25 04:31:23', 5, '2025-03-25 04:31:26', 5),
(5, '2025-03-25', 2, 1, 3, 3, 'batal', '2025-03-25 04:57:50', NULL, NULL, '2025-03-25 04:57:50', 5, '2025-03-25 08:01:56', 5),
(6, '2025-03-25', 1, 1, 1, 3, 'diperiksa', '2025-03-25 08:01:50', '2025-03-25 08:23:52', NULL, '2025-03-25 08:01:50', 5, '2025-03-25 08:23:52', 5),
(7, '2025-03-25', 3, 1, 3, 3, 'menunggu', '2025-03-25 08:28:47', NULL, NULL, '2025-03-25 08:28:47', 5, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id_antrian`),
  ADD KEY `idx_tanggal` (`tanggal`),
  ADD KEY `idx_pasien` (`id_pasien`),
  ADD KEY `idx_poli` (`id_poliklinik`),
  ADD KEY `idx_dokter` (`id_dokter`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
