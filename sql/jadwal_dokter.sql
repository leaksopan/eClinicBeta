-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 08:47 AM
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
-- Table structure for table `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `id_jadwal` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_pasien` int(11) NOT NULL DEFAULT 0,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT current_timestamp(),
  `diubah_pada` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`id_jadwal`, `id_dokter`, `id_poli`, `hari`, `jam_mulai`, `jam_selesai`, `kuota_pasien`, `status`, `keterangan`, `dibuat_pada`, `diubah_pada`) VALUES
(1, 2, 2, 'Rabu', '01:00:00', '05:15:00', 20, 'aktif', 'asd', '2025-03-21 10:15:20', '2025-03-22 16:35:08'),
(2, 3, 5, 'Senin', '16:00:00', '23:00:00', 20, 'aktif', 'Apa', '2025-03-21 10:21:09', '2025-03-25 13:41:48'),
(3, 4, 3, 'Jumat', '13:59:00', '18:12:00', 20, 'aktif', 'WARNING!!', '2025-03-21 11:00:28', NULL),
(4, 3, 3, 'Selasa', '15:44:00', '20:44:00', 10, 'aktif', 'asd', '2025-03-25 13:45:03', NULL),
(6, 3, 1, 'Minggu', '15:12:00', '21:12:00', 10, 'aktif', 'asd', '2025-03-25 14:12:36', NULL),
(9, 3, 1, 'Rabu', '16:12:00', '21:15:00', 10, 'aktif', 'asd', '2025-03-25 14:13:28', NULL),
(10, 3, 1, 'Kamis', '17:13:00', '23:13:00', 10, 'aktif', 'sad', '2025-03-25 14:13:28', NULL),
(11, 4, 3, 'Senin', '16:16:00', '23:20:00', 10, 'aktif', 'asd', '2025-03-25 14:16:54', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_poli` (`id_poli`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `jadwal_dokter_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_dokter_ibfk_2` FOREIGN KEY (`id_poli`) REFERENCES `poliklinik` (`id_poli`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
