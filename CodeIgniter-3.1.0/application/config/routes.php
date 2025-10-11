<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Custom routes untuk aplikasi inventory
$route['barang'] = 'inventory/barang';
$route['barang/tambah'] = 'inventory/tambah_barang';
$route['barang/edit/(:num)'] = 'inventory/edit_barang/$1';
$route['barang/hapus/(:num)'] = 'inventory/hapus_barang/$1';

$route['jenis-barang'] = 'inventory/jenis_barang';
$route['jenis/tambah'] = 'inventory/tambah_jenis';
$route['jenis/edit/(:num)'] = 'inventory/edit_jenis/$1';
$route['jenis/hapus/(:num)'] = 'inventory/hapus_jenis/$1';
$route['jenis/update'] = 'inventory/update_jenis';

$route['barang-masuk'] = 'inventory/barang_masuk';
$route['barang-keluar'] = 'inventory/barang_keluar';

$route['laporan'] = 'laporan/penjualan_bulanan';
$route['laporan/print/(:num)/(:num)'] = 'laporan/print_penjualan/$1/$2';
$route['inventory/hapus_masuk/(:num)'] = 'inventory/hapus_masuk/$1';

// Pastikan route untuk barang masuk sudah ada
$route['barang-masuk'] = 'inventory/barang_masuk';
$route['barang-masuk/hapus/(:num)'] = 'inventory/hapus_masuk/$1';
$route['barang-masuk/tambah'] = 'inventory/tambah_masuk';


// Barang Masuk Routes
$route['barang-masuk'] = 'inventory/barang_masuk';
$route['barang-masuk/hapus/(:num)'] = 'inventory/hapus_masuk/$1';

// Barang Keluar Routes  
$route['barang-keluar'] = 'inventory/barang_keluar';

// Jenis Barang Routes
$route['jenis-barang'] = 'inventory/jenis_barang';

// Barang Routes
$route['barang'] = 'inventory/barang';
$route['barang/tambah'] = 'inventory/tambah_barang';
$route['barang/edit/(:num)'] = 'inventory/edit_barang/$1';
$route['barang/hapus/(:num)'] = 'inventory/hapus_barang/$1';


// Authentication Routes
$route['auth'] = 'auth';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';
$route['inventory'] = 'dashboard';
?>