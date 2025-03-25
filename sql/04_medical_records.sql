-- --------------------------------------------------------
-- TABEL MODUL REKAM MEDIS
-- --------------------------------------------------------

-- Tabel Rekam Medis
CREATE TABLE `rekam_medis` (
  `id_rekam_medis` int(11) NOT NULL AUTO_INCREMENT,
  `no_rekam_medis` varchar(20) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL COMMENT 'Untuk rawat jalan',
  `id_pendaftaran_inap` int(11) DEFAULT NULL COMMENT 'Untuk rawat inap',
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tanggal_periksa` datetime NOT NULL,
  `keluhan_utama` text DEFAULT NULL,
  `riwayat_penyakit` text DEFAULT NULL,
  `riwayat_alergi` text DEFAULT NULL,
  `riwayat_pengobatan` text DEFAULT NULL,
  `pemeriksaan_fisik` text DEFAULT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL COMMENT 'dalam cm',
  `berat_badan` decimal(5,2) DEFAULT NULL COMMENT 'dalam kg',
  `tekanan_darah` varchar(20) DEFAULT NULL,
  `nadi` varchar(20) DEFAULT NULL,
  `suhu` decimal(4,2) DEFAULT NULL COMMENT 'dalam celcius',
  `pernapasan` varchar(20) DEFAULT NULL,
  `kesadaran` enum('Compos Mentis','Somnolen','Sopor','Koma') DEFAULT 'Compos Mentis',
  `catatan_pemeriksaan` text DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rekam_medis`),
  UNIQUE KEY `no_rekam_medis` (`no_rekam_medis`),
  KEY `id_pendaftaran` (`id_pendaftaran`),
  KEY `id_pendaftaran_inap` (`id_pendaftaran_inap`),
  KEY `id_pasien` (`id_pasien`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran_rawat_jalan` (`id_pendaftaran`) ON DELETE SET NULL,
  CONSTRAINT `rekam_medis_ibfk_2` FOREIGN KEY (`id_pendaftaran_inap`) REFERENCES `pendaftaran_rawat_inap` (`id_pendaftaran_inap`) ON DELETE SET NULL,
  CONSTRAINT `rekam_medis_ibfk_3` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  CONSTRAINT `rekam_medis_ibfk_4` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `rekam_medis_ibfk_5` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`)

  -- Pastikan field ini ada di tabel rekam_medis
ALTER TABLE `rekam_medis` 

ADD COLUMN `diagnosis` text DEFAULT NULL,
ADD COLUMN `tindakan` text DEFAULT NULL,
ADD COLUMN `keterangan` text DEFAULT NULL,
ADD COLUMN `is_rujukan` tinyint(1) DEFAULT 0,
ADD COLUMN `rujuk_ke` varchar(100) DEFAULT NULL,
ADD COLUMN `catatan_rujukan` text DEFAULT NULL;

ALTER TABLE `rekam_medis` 
ADD COLUMN `id_kunjungan` int(11) DEFAULT NULL AFTER `id_pasien`,
ADD KEY `id_kunjungan` (`id_kunjungan`),
ADD CONSTRAINT `rekam_medis_ibfk_6` FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan` (`id_kunjungan`) ON DELETE SET NULL;
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel ICD (International Classification of Diseases)
CREATE TABLE `icd` (
  `id_icd` int(11) NOT NULL AUTO_INCREMENT,
  `kode_icd` varchar(20) NOT NULL,
  `nama_icd` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_icd`),
  UNIQUE KEY `kode_icd` (`kode_icd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Diagnosa
CREATE TABLE `diagnosa` (
  `id_diagnosa` int(11) NOT NULL AUTO_INCREMENT,
  `id_rekam_medis` int(11) NOT NULL,
  `id_icd` int(11) NOT NULL,
  `tipe_diagnosa` enum('Utama','Sekunder','Komplikasi') NOT NULL DEFAULT 'Utama',
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_diagnosa`),
  KEY `id_rekam_medis` (`id_rekam_medis`),
  KEY `id_icd` (`id_icd`),
  CONSTRAINT `diagnosa_ibfk_1` FOREIGN KEY (`id_rekam_medis`) REFERENCES `rekam_medis` (`id_rekam_medis`) ON DELETE CASCADE,
  CONSTRAINT `diagnosa_ibfk_2` FOREIGN KEY (`id_icd`) REFERENCES `icd` (`id_icd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Tindakan Master
CREATE TABLE `tindakan_master` (
  `id_tindakan_master` int(11) NOT NULL AUTO_INCREMENT,
  `kode_tindakan` varchar(20) NOT NULL,
  `nama_tindakan` varchar(100) NOT NULL,
  `kategori` enum('Umum','Bedah','Kebidanan','Anak','Jantung','Mata','THT','Gigi','Lainnya') NOT NULL DEFAULT 'Umum',
  `tarif` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tindakan_master`),
  UNIQUE KEY `kode_tindakan` (`kode_tindakan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Tindakan
CREATE TABLE `tindakan` (
  `id_tindakan` int(11) NOT NULL AUTO_INCREMENT,
  `id_rekam_medis` int(11) NOT NULL,
  `id_tindakan_master` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tanggal_tindakan` datetime NOT NULL,
  `hasil_tindakan` text DEFAULT NULL,
  `tarif` decimal(12,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tindakan`),
  KEY `id_rekam_medis` (`id_rekam_medis`),
  KEY `id_tindakan_master` (`id_tindakan_master`),
  KEY `id_dokter` (`id_dokter`),
  CONSTRAINT `tindakan_ibfk_1` FOREIGN KEY (`id_rekam_medis`) REFERENCES `rekam_medis` (`id_rekam_medis`) ON DELETE CASCADE,
  CONSTRAINT `tindakan_ibfk_2` FOREIGN KEY (`id_tindakan_master`) REFERENCES `tindakan_master` (`id_tindakan_master`),
  CONSTRAINT `tindakan_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Resep
CREATE TABLE `resep` (
  `id_resep` int(11) NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(20) NOT NULL,
  `id_rekam_medis` int(11) NOT NULL,
  `tanggal_resep` datetime NOT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Dibatalkan') NOT NULL DEFAULT 'Menunggu',
  `keterangan` text DEFAULT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_petugas` int(11) DEFAULT NULL COMMENT 'Petugas farmasi yang memproses',
  `id_petugas_penyerah` int(11) DEFAULT NULL COMMENT 'Petugas yang menyerahkan obat',
  `tanggal_penyerahan` datetime DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_resep`),
  UNIQUE KEY `no_resep` (`no_resep`),
  KEY `id_rekam_medis` (`id_rekam_medis`),
  KEY `id_dokter` (`id_dokter`),
  KEY `id_petugas` (`id_petugas`),
  KEY `id_petugas_penyerah` (`id_petugas_penyerah`),
  CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`id_rekam_medis`) REFERENCES `rekam_medis` (`id_rekam_medis`) ON DELETE CASCADE,
  CONSTRAINT `resep_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  CONSTRAINT `resep_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL,
  CONSTRAINT `resep_ibfk_4` FOREIGN KEY (`id_petugas_penyerah`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Detail Resep
CREATE TABLE `detail_resep` (
  `id_detail_resep` int(11) NOT NULL AUTO_INCREMENT,
  `id_resep` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `jumlah` decimal(8,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(20) NOT NULL,
  `dosis` varchar(100) DEFAULT NULL,
  `aturan_pakai` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_detail_resep`),
  KEY `id_resep` (`id_resep`),
  KEY `id_item` (`id_item`),
  CONSTRAINT `detail_resep_ibfk_1` FOREIGN KEY (`id_resep`) REFERENCES `resep` (`id_resep`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Catatan Perkembangan
CREATE TABLE `catatan_perkembangan` (
  `id_catatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_rekam_medis` int(11) NOT NULL,
  `tanggal_catatan` datetime NOT NULL,
  `subjektif` text DEFAULT NULL COMMENT 'Keluhan pasien',
  `objektif` text DEFAULT NULL COMMENT 'Hasil pengamatan petugas',
  `assessment` text DEFAULT NULL COMMENT 'Penilaian',
  `planning` text DEFAULT NULL COMMENT 'Rencana tindakan',
  `id_petugas` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_catatan`),
  KEY `id_rekam_medis` (`id_rekam_medis`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `catatan_perkembangan_ibfk_1` FOREIGN KEY (`id_rekam_medis`) REFERENCES `rekam_medis` (`id_rekam_medis`) ON DELETE CASCADE,
  CONSTRAINT `catatan_perkembangan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Tindak Lanjut
CREATE TABLE `tindak_lanjut` (
  `id_tindak_lanjut` int(11) NOT NULL AUTO_INCREMENT,
  `id_rekam_medis` int(11) NOT NULL,
  `jenis_tindak_lanjut` enum('Kontrol Ulang','Rujuk','Rawat Inap','Pulang') NOT NULL,
  `tanggal_tindak_lanjut` date DEFAULT NULL COMMENT 'Tanggal kontrol ulang atau rujuk',
  `tujuan` varchar(100) DEFAULT NULL COMMENT 'Tempat rujukan atau poli kontrol',
  `catatan` text DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diubah_pada` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tindak_lanjut`),
  KEY `id_rekam_medis` (`id_rekam_medis`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `tindak_lanjut_ibfk_1` FOREIGN KEY (`id_rekam_medis`) REFERENCES `rekam_medis` (`id_rekam_medis`) ON DELETE CASCADE,
  CONSTRAINT `tindak_lanjut_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk tindakan master
INSERT INTO `tindakan_master` (`kode_tindakan`, `nama_tindakan`, `kategori`, `tarif`, `status`) VALUES
('KONS-UMUM', 'Konsultasi Dokter Umum', 'Umum', 50000.00, 'aktif'),
('KONS-SPESIALIS', 'Konsultasi Dokter Spesialis', 'Umum', 150000.00, 'aktif'),
('INJ-01', 'Injeksi Obat', 'Umum', 25000.00, 'aktif'),
('WOUND-01', 'Dressing Luka Kecil', 'Umum', 50000.00, 'aktif'),
('WOUND-02', 'Dressing Luka Sedang', 'Umum', 75000.00, 'aktif'),
('WOUND-03', 'Dressing Luka Besar', 'Umum', 100000.00, 'aktif'),
('VITAL-01', 'Pemeriksaan Tanda Vital', 'Umum', 15000.00, 'aktif'); 