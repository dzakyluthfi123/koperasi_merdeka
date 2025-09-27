<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'inventory';
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


?>