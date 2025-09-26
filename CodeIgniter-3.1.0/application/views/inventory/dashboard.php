<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $total_barang ?></h4>
                        <p>Total Barang</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $total_stok ?></h4>
                        <p>Total Stok</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-warehouse fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= date('d M Y') ?></h4>
                        <p>Tanggal Hari Ini</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>KOPERASI KELURAHAN MERAH PUTIH PROCOT</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-store fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Barang Stok Rendah</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Min Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $barang_stok_rendah = array_filter($barang, function($b) {
                                return $b->stok <= $b->min_stok;
                            });
                            
                            if ($barang_stok_rendah) {
                                foreach($barang_stok_rendah as $b): 
                            ?>
                            <tr class="table-warning">
                                <td><?= $b->nama_barang ?></td>
                                <td><span class="badge bg-danger"><?= $b->stok ?></span></td>
                                <td><?= $b->min_stok ?></td>
                            </tr>
                            <?php 
                                endforeach; 
                            } else {
                            ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada barang dengan stok rendah</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <a href="<?= base_url('barang') ?>" class="btn btn-outline-primary btn-lg p-3">
                            <i class="fas fa-box fa-2x"></i><br>
                            <span>Data Barang</span>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="<?= base_url('barang-masuk') ?>" class="btn btn-outline-success btn-lg p-3">
                            <i class="fas fa-arrow-down fa-2x"></i><br>
                            <span>Barang Masuk</span>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="<?= base_url('barang-keluar') ?>" class="btn btn-outline-danger btn-lg p-3">
                            <i class="fas fa-arrow-up fa-2x"></i><br>
                            <span>Barang Keluar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Semua Barang</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($barang as $b): ?>
                            <tr>
                                <td><?= $b->kode_barang ?></td>
                                <td><?= $b->nama_barang ?></td>
                                <td><?= $b->nama_jenis ?></td>
                                <td>
                                    <span class="badge <?= $b->stok <= $b->min_stok ? 'bg-danger' : 'bg-success' ?>">
                                        <?= $b->stok ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($b->harga_beli, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($b->harga_jual, 0, ',', '.') ?></td>
                                <td><?= $b->satuan ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>