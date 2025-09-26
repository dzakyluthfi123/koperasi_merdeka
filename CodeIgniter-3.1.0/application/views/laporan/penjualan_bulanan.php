<?php
// Tambahkan di paling atas untuk handling error
if (!isset($bulan)) $bulan = date('n'); // n = bulan tanpa leading zero
if (!isset($tahun)) $tahun = date('Y');
if (!isset($penjualan)) $penjualan = [];
if (!isset($total)) $total = null;

// Definisikan bulan_list dengan format yang konsisten
$bulan_list = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
?>

<div class="d-flex justify-content-between mb-3">
    <h3>Laporan Penjualan Bulanan</h3>
</div>

<div class="card">
    <div class="card-header">
        <h5>Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('laporan') ?>">
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
                            <?php if ($penjualan && !empty($penjualan) && isset($bulan_list[$bulan])): ?>
                            <a href="<?= base_url('laporan/print/'.$bulan.'/'.$tahun) ?>" class="btn btn-success" target="_blank">
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

<?php if ($penjualan && !empty($penjualan)): ?>
<div class="card mt-4">
    <div class="card-header">
        <h5>Data Penjualan Bulan <?= isset($bulan_list[$bulan]) ? $bulan_list[$bulan] : 'Bulan ' . $bulan ?> <?= $tahun ?></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah Terjual</th>
                        <th>Harga Rata-rata</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    foreach($penjualan as $p): 
                        $grand_total += isset($p->total_pendapatan) ? $p->total_pendapatan : 0;
                    ?>
                    <tr>
                        <td><?= isset($p->tanggal_keluar) ? date('d/m/Y', strtotime($p->tanggal_keluar)) : '-' ?></td>
                        <td><?= isset($p->nama_barang) ? $p->nama_barang : '-' ?></td>
                        <td><?= isset($p->nama_jenis) ? $p->nama_jenis : '-' ?></td>
                        <td><?= isset($p->total_terjual) ? number_format($p->total_terjual, 0, ',', '.') : 0 ?></td>
                        <td>Rp <?= isset($p->rata_harga_jual) ? number_format($p->rata_harga_jual, 0, ',', '.') : 0 ?></td>
                        <td>Rp <?= isset($p->total_pendapatan) ? number_format($p->total_pendapatan, 0, ',', '.') : 0 ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <td colspan="5" class="text-end"><strong>Total Penjualan:</strong></td>
                        <td><strong>Rp <?= number_format($grand_total, 0, ',', '.') ?></strong></td>
                    </tr>
                    <?php if ($total): ?>
                    <tr class="table-info">
                        <td colspan="5" class="text-end"><strong>Summary:</strong></td>
                        <td>
                            <strong>
                                Total Barang Terjual: <?= isset($total->total_barang_terjual) ? number_format($total->total_barang_terjual, 0, ',', '.') : 0 ?><br>
                                Jenis Barang: <?= isset($total->jumlah_jenis_barang) ? $total->jumlah_jenis_barang : 0 ?>
                            </strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Penjualan</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h3>Rp <?= number_format($grand_total, 0, ',', '.') ?></h3>
                    <p class="text-muted">Total Pendapatan</p>
                </div>
                <div class="row text-center mt-3">
                    <div class="col-6">
                        <h4><?= isset($total->total_barang_terjual) ? number_format($total->total_barang_terjual, 0, ',', '.') : 0 ?></h4>
                        <p class="text-muted">Barang Terjual</p>
                    </div>
                    <div class="col-6">
                        <h4><?= isset($total->jumlah_jenis_barang) ? $total->jumlah_jenis_barang : 0 ?></h4>
                        <p class="text-muted">Jenis Barang</p>
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
                <p><strong>Tanggal Cetak:</strong> <?= date('d/m/Y H:i:s') ?></p>
                <p><strong>Status:</strong> <span class="badge bg-success">Selesai</span></p>
                <?php if (isset($bulan_list[$bulan])): ?>
                <a href="<?= base_url('laporan/print/'.$bulan.'/'.$tahun) ?>" class="btn btn-primary mt-2" target="_blank">
                    <i class="fas fa-print"></i> Print Laporan
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php elseif (isset($penjualan) && empty($penjualan)): ?>
<div class="card mt-4">
    <div class="card-body text-center">
        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
        <h4>Data penjualan tidak ditemukan</h4>
        <p class="text-muted">Tidak ada data penjualan untuk periode <?= isset($bulan_list[$bulan]) ? $bulan_list[$bulan] : 'Bulan ' . $bulan ?> <?= $tahun ?>.</p>
    </div>
</div>
<?php endif; ?>