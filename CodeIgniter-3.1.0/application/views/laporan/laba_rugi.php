<div class="d-flex justify-content-between mb-3">
    <h3>Laporan Laba Rugi</h3>
</div>

<div class="card">
    <div class="card-header">
        <h5>Filter Laporan Laba Rugi</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('laporan/laba_rugi') ?>">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Bulan</label>
                        <select class="form-control" name="bulan" required>
                            <option value="">Pilih Bulan</option>
                            <?php foreach($bulan_list as $key => $value): ?>
                            <option value="<?= $key ?>" <?= $key == $bulan ? 'selected' : '' ?>>
                                <?= $value ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <select class="form-control" name="tahun" required>
                            <option value="">Pilih Tahun</option>
                            <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                            <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>>
                                <?= $i ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <?php if (isset($laba_rugi) && !empty($laba_rugi)): ?>
                            <a href="<?= base_url('laporan/print_laba_rugi/'.$bulan.'/'.$tahun) ?>" class="btn btn-success" target="_blank">
                                <i class="fas fa-print"></i> Print
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (isset($laba_rugi) && !empty($laba_rugi)): ?>
<div class="card mt-4">
    <div class="card-header">
        <h5>Data Laba Rugi Bulan <?= isset($bulan_list[$bulan]) ? $bulan_list[$bulan] : 'Bulan ' . $bulan ?> <?= $tahun ?></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Laba/Unit</th>
                        <th>Total Penjualan</th>
                        <th>Total Harga Beli</th>
                        <th>Laba/Rugi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_penjualan = 0;
                    $total_harga_beli = 0;
                    $total_laba_rugi = 0;
                    
                    foreach($laba_rugi as $lr): 
                        $total_penjualan += $lr->total_penjualan;
                        $total_harga_beli += $lr->total_harga_beli;
                        $total_laba_rugi += $lr->laba_rugi;
                        
                        $laba_class = $lr->laba_rugi >= 0 ? 'text-success' : 'text-danger';
                        $laba_icon = $lr->laba_rugi >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                    ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($lr->tanggal_keluar)) ?></td>
                        <td><?= $lr->nama_barang ?></td>
                        <td><?= $lr->nama_jenis ?></td>
                        <td><?= $lr->jumlah ?></td>
                        <td>Rp <?= number_format($lr->harga_beli, 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($lr->harga_jual, 0, ',', '.') ?></td>
                        <td class="<?= $lr->laba_per_unit >= 0 ? 'text-success' : 'text-danger' ?>">
                            Rp <?= number_format($lr->laba_per_unit, 0, ',', '.') ?>
                        </td>
                        <td>Rp <?= number_format($lr->total_penjualan, 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($lr->total_harga_beli, 0, ',', '.') ?></td>
                        <td class="<?= $laba_class ?>">
                            <i class="fas <?= $laba_icon ?>"></i>
                            Rp <?= number_format($lr->laba_rugi, 0, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <td colspan="7" class="text-end"><strong>GRAND TOTAL:</strong></td>
                        <td><strong>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></strong></td>
                        <td><strong>Rp <?= number_format($total_harga_beli, 0, ',', '.') ?></strong></td>
                        <td class="<?= $total_laba_rugi >= 0 ? 'text-success' : 'text-danger' ?>">
                            <strong>
                                <i class="fas <?= $total_laba_rugi >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' ?>"></i>
                                Rp <?= number_format($total_laba_rugi, 0, ',', '.') ?>
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Laba Rugi</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <h3 class="<?= $total_laba_rugi >= 0 ? 'text-success' : 'text-danger' ?>">
                        Rp <?= number_format($total_laba_rugi, 0, ',', '.') ?>
                    </h3>
                    <p class="text-muted">Total <?= $total_laba_rugi >= 0 ? 'Laba' : 'Rugi' ?></p>
                </div>
                <div class="row text-center">
                    <div class="col-4">
                        <h5 class="text-primary">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></h5>
                        <p class="text-muted small">Total Penjualan</p>
                    </div>
                    <div class="col-4">
                        <h5 class="text-info">Rp <?= number_format($total_harga_beli, 0, ',', '.') ?></h5>
                        <p class="text-muted small">Total Harga Beli</p>
                    </div>
                    <div class="col-4">
                        <h5 class="<?= $total_laba_rugi >= 0 ? 'text-success' : 'text-danger' ?>">
                            <?= number_format(($total_penjualan > 0 ? ($total_laba_rugi / $total_penjualan * 100) : 0), 1) ?>%
                        </h5>
                        <p class="text-muted small">Margin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Laporan</h5>
            </div>
            <div class="card-body">
                <p><strong>Periode:</strong> <?= isset($bulan_list[$bulan]) ? $bulan_list[$bulan] : 'Bulan ' . $bulan ?> <?= $tahun ?></p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-<?= $total_laba_rugi >= 0 ? 'success' : 'danger' ?>">
                        <?= $total_laba_rugi >= 0 ? 'LABA' : 'RUGI' ?>
                    </span>
                </p>
                <p><strong>Total Barang Terjual:</strong> <?= isset($total->total_barang_terjual) ? $total->total_barang_terjual : 0 ?> unit</p>
                <p><strong>Rata-rata Laba per Unit:</strong> Rp <?= isset($total->rata_rata_laba_per_unit) ? number_format($total->rata_rata_laba_per_unit, 0, ',', '.') : 0 ?></p>
                
                <a href="<?= base_url('laporan/print_laba_rugi/'.$bulan.'/'.$tahun) ?>" class="btn btn-primary mt-2" target="_blank">
                    <i class="fas fa-print"></i> Print Laporan Laba Rugi
                </a>
            </div>
        </div>
    </div>
</div>

<?php elseif (isset($laba_rugi) && empty($laba_rugi)): ?>
<div class="card mt-4">
    <div class="card-body text-center">
        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
        <h4>Data laba rugi tidak ditemukan</h4>
        <p class="text-muted">Tidak ada data transaksi untuk periode <?= isset($bulan_list[$bulan]) ? $bulan_list[$bulan] : 'Bulan ' . $bulan ?> <?= $tahun ?>.</p>
    </div>
</div>
<?php endif; ?>