-- SQL untuk menambahkan akun demo dengan berbagai role
USE `eClinic`;

-- Pastikan tabel role sudah memiliki data role yang diperlukan
-- Jika belum ada, tambahkan role baru
INSERT IGNORE INTO `role` (`nama_role`, `deskripsi`) VALUES
('Administrator', 'Akses penuh ke semua fitur sistem'),
('Dokter', 'Akses ke fitur medis dan rekam medis'),
('Perawat', 'Akses ke pendaftaran dan bantuan medis'),
('Apoteker', 'Akses ke modul farmasi'),
('Kasir', 'Akses ke modul kasir dan pembayaran'),
('Pendaftaran', 'Akses ke modul pendaftaran'),
('Laboratorium', 'Akses ke modul laboratorium'),
('Radiologi', 'Akses ke modul radiologi'),
('Keuangan', 'Akses ke modul keuangan'),
('Gudang', 'Akses ke modul inventaris'),
('Pasien', 'Akses terbatas ke data pribadi');

-- Tambahkan akun pengguna demo
-- Password dienkripsi dengan bcrypt (semua password: nama_role123)

-- Admin (password: admin123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('admin', '$2y$10$wXrUZpmzPHR9bKqXSN5RVeC5jfnhpAjIJk2.b0bvWlUqIeLaxnTmG', 'Administrator Sistem', 'admin@eclinic.com', '081234567890', 'Jl. Admin No. 1', 1, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$wXrUZpmzPHR9bKqXSN5RVeC5jfnhpAjIJk2.b0bvWlUqIeLaxnTmG', `status` = 'aktif';

-- Dokter (password: dokter123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('dokter', '$2y$10$rZtb6lHDEKKhK0CUqYKEPeVBGDxoI4h3oeLxJvNe0Qb20.bQJSoRO', 'Dr. Budi Santoso', 'dokter@eclinic.com', '081234567891', 'Jl. Dokter No. 2', 2, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$rZtb6lHDEKKhK0CUqYKEPeVBGDxoI4h3oeLxJvNe0Qb20.bQJSoRO', `status` = 'aktif';

-- Perawat (password: perawat123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('perawat', '$2y$10$9hQPHMoHQUHD9.RES7wmgeP9.W1Mq2mVmAc3hPOvY9a1Ym3UfBhMK', 'Siti Nurjanah', 'perawat@eclinic.com', '081234567892', 'Jl. Perawat No. 3', 3, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$9hQPHMoHQUHD9.RES7wmgeP9.W1Mq2mVmAc3hPOvY9a1Ym3UfBhMK', `status` = 'aktif';

-- Apoteker (password: apoteker123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('apoteker', '$2y$10$hWZRjEl36jzWpjVOFj18pOMsomvHq/OquO7LvvkYTNWp0AiPQp5VC', 'Agus Farmasi', 'apoteker@eclinic.com', '081234567893', 'Jl. Apoteker No. 4', 4, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$hWZRjEl36jzWpjVOFj18pOMsomvHq/OquO7LvvkYTNWp0AiPQp5VC', `status` = 'aktif';

-- Kasir (password: kasir123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('kasir', '$2y$10$LJx.7Sm.5cykiS8nRVQdL.hS1DLwwmzE4zH2YpiZ0PUWvdQbWvLvC', 'Dewi Kasir', 'kasir@eclinic.com', '081234567894', 'Jl. Kasir No. 5', 5, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$LJx.7Sm.5cykiS8nRVQdL.hS1DLwwmzE4zH2YpiZ0PUWvdQbWvLvC', `status` = 'aktif';

-- Pendaftaran (password: pendaftaran123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('pendaftaran', '$2y$10$hF18/DdY1G0x0YhKjV5ZVOGELOCn/0iEVsbwXIlk1Zk.UhM8nGGr6', 'Rani Daftar', 'pendaftaran@eclinic.com', '081234567895', 'Jl. Pendaftaran No. 6', 6, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$hF18/DdY1G0x0YhKjV5ZVOGELOCn/0iEVsbwXIlk1Zk.UhM8nGGr6', `status` = 'aktif';

-- Laboratorium (password: laborat123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('laborat', '$2y$10$j.CZvTG8R57wVHp7vqHpZOS8LDxAUQnPrSUHe0g.eZMcJZbMuq6w2', 'Didi Laborat', 'laborat@eclinic.com', '081234567896', 'Jl. Laboratorium No. 7', 7, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$j.CZvTG8R57wVHp7vqHpZOS8LDxAUQnPrSUHe0g.eZMcJZbMuq6w2', `status` = 'aktif';

-- Radiologi (password: radiologi123)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `alamat`, `id_role`, `status`) VALUES
('radiologi', '$2y$10$DLz.btAvT/LZAoOzyQVqrOT9iyMv8AXPq0UtJHaqmhBb.wY0BgdEC', 'Eko Radiologi', 'radiologi@eclinic.com', '081234567897', 'Jl. Radiologi No. 8', 8, 'aktif')
ON DUPLICATE KEY UPDATE `password` = '$2y$10$DLz.btAvT/LZAoOzyQVqrOT9iyMv8AXPq0UtJHaqmhBb.wY0BgdEC', `status` = 'aktif'; 