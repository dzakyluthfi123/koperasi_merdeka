<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Dashboard</h4>
                    <div>
                        <span class="badge bg-primary"><?= $user['role'] ?></span>
                        <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger btn-sm">Logout</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5>Selamat datang, <?= $user['nama_lengkap'] ?>!</h5>
                        <p class="mb-0">Anda login sebagai <strong><?= $user['username'] ?></strong> (<?= $user['role'] ?>)</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Laporan</h5>
                                    <p class="card-text">Kelola laporan penjualan</p>
                                    <a href="<?= base_url('laporan') ?>" class="btn btn-light">Buka Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>