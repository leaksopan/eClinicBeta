<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Authentication
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['forgot_password'] = 'auth/forgot_password';

// Dashboard
$route['dashboard'] = 'dashboard/index';

// Surat Module
$route['surat'] = 'surat/index';
$route['surat/buat'] = 'surat/buat';
$route['surat/buat/(:any)'] = 'surat/buat/$1';
$route['surat/lihat/(:num)'] = 'surat/lihat/$1';
$route['surat/cetak/(:num)'] = 'surat/cetak/$1';
$route['surat/hapus/(:num)'] = 'surat/hapus/$1';

// Pasien Module
$route['pasien'] = 'pasien/index';
$route['pasien/tambah'] = 'pasien/tambah';
$route['pasien/edit/(:num)'] = 'pasien/edit/$1';
$route['pasien/lihat/(:num)'] = 'pasien/lihat/$1';
$route['pasien/hapus/(:num)'] = 'pasien/hapus/$1';
$route['pasien/cari'] = 'pasien/cari';
$route['pasien/kartu/(:num)'] = 'pasien/kartu/$1';
$route['pasien/cetak'] = 'pasien/cetak';
$route['pasien/cetak/(:num)'] = 'pasien/cetak/$1';
$route['pasien/statistik'] = 'pasien/statistik';

// Klinik Module
$route['klinik'] = 'klinik/index';

// Poliklinik Routes
$route['klinik/poli'] = 'klinik/poli';
$route['klinik/tambah_poli'] = 'klinik/tambah_poli';
$route['klinik/edit_poli/(:num)'] = 'klinik/edit_poli/$1';
$route['klinik/hapus_poli/(:num)'] = 'klinik/hapus_poli/$1';

// Dokter Routes
$route['klinik/dokter'] = 'klinik/dokter';
$route['klinik/tambah_dokter'] = 'klinik/tambah_dokter';
$route['klinik/edit_dokter/(:num)'] = 'klinik/edit_dokter/$1';
$route['klinik/hapus_dokter/(:num)'] = 'klinik/hapus_dokter/$1';

// Jadwal Dokter Routes
$route['klinik/jadwal'] = 'klinik/jadwal';
$route['klinik/tambah_jadwal'] = 'klinik/tambah_jadwal';
$route['klinik/edit_jadwal/(:num)'] = 'klinik/edit_jadwal/$1';
$route['klinik/hapus_jadwal/(:num)'] = 'klinik/hapus_jadwal/$1';

// Ruang Inap Routes
$route['klinik/ruangan'] = 'klinik/ruangan';
$route['klinik/tambah_ruangan'] = 'klinik/tambah_ruangan';
$route['klinik/edit_ruangan/(:num)'] = 'klinik/edit_ruangan/$1';
$route['klinik/hapus_ruangan/(:num)'] = 'klinik/hapus_ruangan/$1';
$route['klinik/bed/(:num)'] = 'klinik/bed/$1';
$route['klinik/tambah_bed/(:num)'] = 'klinik/tambah_bed/$1';
$route['klinik/edit_bed/(:num)'] = 'klinik/edit_bed/$1';
$route['klinik/hapus_bed/(:num)'] = 'klinik/hapus_bed/$1';

// Dokter Module
$route['dokter'] = 'dokter/index';
$route['dokter/tambah'] = 'dokter/tambah';
$route['dokter/edit/(:num)'] = 'dokter/edit/$1';
$route['dokter/lihat/(:num)'] = 'dokter/lihat/$1';
$route['dokter/hapus/(:num)'] = 'dokter/hapus/$1';
$route['dokter/cari'] = 'dokter/cari';
$route['dokter/statistik'] = 'dokter/statistik';
$route['dokter/jadwal/(:num)'] = 'dokter/jadwal/$1';
$route['dokter/tambah_jadwal/(:num)'] = 'dokter/tambah_jadwal/$1';
$route['dokter/edit_jadwal/(:num)'] = 'dokter/edit_jadwal/$1';
$route['dokter/hapus_jadwal/(:num)'] = 'dokter/hapus_jadwal/$1';

// Pengguna Module
$route['pengguna'] = 'pengguna/index';
$route['pengguna/tambah'] = 'pengguna/tambah';
$route['pengguna/edit/(:num)'] = 'pengguna/edit/$1';
$route['pengguna/lihat/(:num)'] = 'pengguna/lihat/$1';
$route['pengguna/hapus/(:num)'] = 'pengguna/hapus/$1';
$route['pengguna/reset_password/(:num)'] = 'pengguna/reset_password/$1';
$route['pengguna/aktifkan/(:num)'] = 'pengguna/aktifkan/$1';
$route['pengguna/nonaktifkan/(:num)'] = 'pengguna/nonaktifkan/$1';
$route['pengguna/ganti_password'] = 'pengguna/ganti_password';

// Jadwal Module
$route['jadwal'] = 'jadwal/index';
$route['jadwal/tambah'] = 'jadwal/tambah';
$route['jadwal/edit/(:num)'] = 'jadwal/edit/$1';
$route['jadwal/hapus/(:num)'] = 'jadwal/hapus/$1';
$route['jadwal/poli/(:num)'] = 'jadwal/poli/$1';
$route['jadwal/dokter/(:num)'] = 'jadwal/dokter/$1';
$route['jadwal/hari/(:any)'] = 'jadwal/hari/$1';
