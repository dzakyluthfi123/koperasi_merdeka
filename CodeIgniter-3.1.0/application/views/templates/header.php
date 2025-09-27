<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Koperasi Merdeka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <!-- Logo -->
        <div class="text-center mb-3">
        <img src="<?= base_url('assets/images/logo-koperasi.png') ?>" 
                 class="img-fluid rounded-circle"
                 style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
        </div>
        
        <h5 class="text-white text-center mb-4" style="line-height: 1.3;">
            KOPERASI KELURAHAN<br>
            <span class="text-warning">MERAH PUTIH PROCOT</span>
        </h5>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= base_url() ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'barang' ? 'active' : '' ?>" href="<?= base_url('barang') ?>">
                    <i class="fas fa-box"></i> Data Barang
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'jenis-barang' ? 'active' : '' ?>" href="<?= base_url('jenis-barang') ?>">
                    <i class="fas fa-tags"></i> Jenis Barang
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'barang-masuk' ? 'active' : '' ?>" href="<?= base_url('barang-masuk') ?>">
                    <i class="fas fa-arrow-down"></i> Barang Masuk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'barang-keluar' ? 'active' : '' ?>" href="<?= base_url('barang-keluar') ?>">
                    <i class="fas fa-arrow-up"></i> Barang Keluar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'laporan' ? 'active' : '' ?>" href="<?= base_url('laporan') ?>">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
            </li>
            <li class="nav-item">
    <a class="nav-link <?= uri_string() == 'laporan/laba_rugi' ? 'active' : '' ?>" href="<?= base_url('laporan/laba_rugi') ?>">
        <i class="fas fa-chart-line"></i> Laporan Laba Rugi
    </a>
</li>
        </ul>
    </div>
</nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $title ?></h1>
                </div>