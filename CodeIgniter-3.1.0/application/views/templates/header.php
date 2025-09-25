<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Koperasi Merdeka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 10px 15px;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
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
                    <h4 class="text-white text-center mb-4">Koperasi Merdeka</h4>
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
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?= isset($title) ? $title : 'Koperasi Merdeka' ?></h1>
                </div>