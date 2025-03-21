# PENTING !!!
Jangan pernah langsung aplikasikan ini ke clinic tanpa melakukan analisa lebih lanjut
APP ini hanya untuk tujuan pembelajaran alur dari sistem kerja clinic sederhana yang belum terconnect ke API dari kemenkes

Feel free to clone dan pelajari, tapi jika di implementasikan dengan base file ini, jngan lupa credit github.com/leaksopan
# Database SQL eClinic

File-file SQL ini berisi struktur database untuk sistem eClinic. Database dirancang menggunakan MySQL/MariaDB dan menggunakan struktur modular untuk memudahkan pemahaman dan pengelolaan.

## Cara Menggunakan

1. Pastikan MySQL/MariaDB sudah terinstal di server Anda.
2. Ada dua cara untuk mengimpor database:

### Cara 1: Menggunakan file utama

Jalankan perintah berikut di terminal:

```bash
mysql -u username -p < sql/00_main.sql
```

Ganti `username` dengan username MySQL Anda. Anda akan diminta memasukkan password.

### Cara 2: Menggunakan phpMyAdmin

1. Buka phpMyAdmin
2. Buat database baru bernama "eClinic"
3. Pilih database "eClinic"
4. Klik tab "Import"
5. Pilih file SQL yang ingin diimpor
6. Klik "Go" atau "Import"
7. Ulangi langkah 4-6 untuk setiap file SQL, dengan urutan sebagai berikut:

## Urutan Import

Jika Anda mengimpor file secara manual, impor file dengan urutan berikut:

1. `01_core_tables.sql` - Tabel inti (pengguna, hak akses, dll)
2. `02_registration_module.sql` - Modul pendaftaran pasien
3. `03_clinic_module.sql` - Modul klinik (dokter, poliklinik)
4. `04_medical_records.sql` - Modul rekam medis
5. `05_pharmacy_module.sql` - Modul farmasi
6. `06_laboratory_radiology.sql` - Modul laboratorium dan radiologi
7. `07_finance_module.sql` - Modul keuangan
8. `08_inventory_module.sql` - Modul inventory/stok
9. `09_letter_module.sql` - Modul cetak surat
10. `10_system_settings.sql` - Pengaturan sistem

## Struktur Database

Database eClinic terdiri dari 10 modul utama:

1. **Core System**: Manajemen pengguna, hak akses, dan fungsi inti sistem
2. **Pendaftaran**: Pendaftaran pasien, antrian, dan administrasi awal
3. **Klinik**: Manajemen dokter, poliklinik, dan jadwal dokter
4. **Rekam Medis**: Pencatatan rekam medis pasien
5. **Farmasi**: Manajemen obat, resep, dan penjualan obat
6. **Laboratorium & Radiologi**: Pemeriksaan lab dan radiologi
7. **Keuangan**: Manajemen transaksi keuangan dan akuntansi
8. **Inventory**: Manajemen stok obat dan barang
9. **Surat**: Pencetakan berbagai surat medis dengan template yang tersimpan di kode aplikasi (PHP)
10. **Pengaturan Sistem**: Konfigurasi sistem, menu, dan parameter

## Catatan

- Semua file SQL menggunakan format UTF-8 dan kolasi utf8mb4_general_ci
- Struktur tabel menggunakan foreign key untuk menjaga integritas referensial
- Password default untuk admin adalah 'admin123' (di-hash menggunakan bcrypt)
- Semua nama kolom menggunakan Bahasa Indonesia
- Template surat disimpan dalam kode PHP (bukan database) untuk kemudahan dalam pemeliharaan dan versioning 
