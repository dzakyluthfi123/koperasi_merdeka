<div class="d-flex justify-content-between mb-3">
    <h3>Laporan Laba Rugi</h3>
    <?php if (isset($laba_rugi) && !empty($laba_rugi)): ?>
    <div>
        <a href="<?= base_url('laporan/print_laba_rugi/'.$bulan.'/'.$tahun) ?>" class="btn btn-success" target="_blank">
            <i class="fas fa-print"></i> Print Laporan
        </a>
       
    </div>
    <?php endif; ?>
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
                            <?php
                            $bulan_list = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            
                            
                            $bulan_selected = isset($bulan) ? $bulan : date('m');
                            $tahun_selected = isset($tahun) ? $tahun : date('Y');
                            
                            foreach($bulan_list as $key => $value): 
                            ?>
                            <option value="<?= $key ?>" <?= $key == $bulan_selected ? 'selected' : '' ?>>
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
                            <?php 
                            $tahun_sekarang = date('Y');
                            for($i = $tahun_sekarang; $i >= 2020; $i--): 
                            ?>
                            <option value="<?= $i ?>" <?= $i == $tahun_selected ? 'selected' : '' ?>>
                                <?= $i ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Jenis Barang</label>
                        <select class="form-control" name="jenis_barang">
                            <option value="">Semua Jenis</option>
                            <?php foreach($jenis_barang as $jenis): ?>
                            <option value="<?= $jenis->id ?>" <?= (isset($jenis_selected) && $jenis_selected == $jenis->id) ? 'selected' : '' ?>>
                                <?= $jenis->nama_jenis ?>
                            </option>
                            <?php endforeach; ?>
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
                            <a href="<?= base_url('laporan/laba_rugi') ?>" class="btn btn-secondary">
                                <i class="fas fa-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php 

$total_penjualan = 0;
$total_harga_beli = 0;
$total_laba_rugi = 0;
$total_barang_terjual = 0;
$jumlah_jenis_barang = 0;


if (isset($laba_rugi) && !empty($laba_rugi)) {
    foreach($laba_rugi as $lr) {
        
        $harga_beli = isset($lr->harga_beli) ? $lr->harga_beli : 0;
        $harga_jual = isset($lr->harga_jual) ? $lr->harga_jual : 0;
        $jumlah = isset($lr->jumlah) ? $lr->jumlah : 0;
        $total_penjualan_item = isset($lr->total_penjualan) ? $lr->total_penjualan : ($harga_jual * $jumlah);
        $total_harga_beli_item = isset($lr->total_harga_beli) ? $lr->total_harga_beli : ($harga_beli * $jumlah);
        $laba_rugi_item = isset($lr->laba_rugi) ? $lr->laba_rugi : ($total_penjualan_item - $total_harga_beli_item);
        
        $total_penjualan += $total_penjualan_item;
        $total_harga_beli += $total_harga_beli_item;
        $total_laba_rugi += $laba_rugi_item;
    }
    
    
    $total_barang_terjual = 0;
    $jenis_barang_unik = [];
    
    foreach($laba_rugi as $lr) {
        $jumlah = isset($lr->jumlah) ? $lr->jumlah : 0;
        $total_barang_terjual += $jumlah;
        
        $jenis = isset($lr->nama_jenis) ? $lr->nama_jenis : 'Tidak Diketahui';
        if (!in_array($jenis, $jenis_barang_unik)) {
            $jenis_barang_unik[] = $jenis;
        }
    }
    
    $jumlah_jenis_barang = count($jenis_barang_unik);
}
?>

<?php if (isset($laba_rugi) && !empty($laba_rugi)): ?>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= number_format($total_barang_terjual, 0) ?></h4>
                        <p class="mb-0">Barang Terjual</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></h4>
                        <p class="mb-0">Total Penjualan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">Rp <?= number_format($total_harga_beli, 0, ',', '.') ?></h4>
                        <p class="mb-0">Total HPP</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-basket fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-<?= $total_laba_rugi >= 0 ? 'info' : 'danger' ?> text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">Rp <?= number_format($total_laba_rugi, 0, ',', '.') ?></h4>
                        <p class="mb-0">Laba/Rugi</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Laba Rugi Bulan <?= $bulan_list[$bulan_selected] ?> <?= $tahun_selected ?></h5>
        <span class="badge bg-primary"><?= count($laba_rugi) ?> Transaksi</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Laba/Unit</th>
                        <th>Total Jual</th>
                        <th>Total HPP</th>
                        <th>Laba/Rugi</th>
                        <th>Margin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    
                    $table_total_penjualan = 0;
                    $table_total_hpp = 0;
                    $table_total_laba = 0;
                    
                    foreach($laba_rugi as $lr): 
                        
                        $kode_transaksi = isset($lr->kode_transaksi) ? $lr->kode_transaksi : 'TRX-' . $no;
                        $nama_barang = isset($lr->nama_barang) ? $lr->nama_barang : 'Barang Tidak Diketahui';
                        $nama_jenis = isset($lr->nama_jenis) ? $lr->nama_jenis : 'Tidak Diketahui';
                        $jumlah = isset($lr->jumlah) ? $lr->jumlah : 0;
                        $harga_beli = isset($lr->harga_beli) ? $lr->harga_beli : 0;
                        $harga_jual = isset($lr->harga_jual) ? $lr->harga_jual : 0;
                        $tanggal_keluar = isset($lr->tanggal_keluar) ? $lr->tanggal_keluar : date('Y-m-d');
                        
                        
                        $total_penjualan_item = isset($lr->total_penjualan) ? $lr->total_penjualan : ($harga_jual * $jumlah);
                        $total_hpp_item = isset($lr->total_harga_beli) ? $lr->total_harga_beli : ($harga_beli * $jumlah);
                        $laba_rugi_item = isset($lr->laba_rugi) ? $lr->laba_rugi : ($total_penjualan_item - $total_hpp_item);
                        
                        $laba_per_unit = $harga_jual - $harga_beli;
                        $margin = $harga_jual > 0 ? (($harga_jual - $harga_beli) / $harga_jual) * 100 : 0;
                        
                        $table_total_penjualan += $total_penjualan_item;
                        $table_total_hpp += $total_hpp_item;
                        $table_total_laba += $laba_rugi_item;
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($tanggal_keluar)) ?></td>
                        <td><span class="badge bg-secondary"><?= $kode_transaksi ?></span></td>
                        <td><?= $nama_barang ?></td>
                        <td><span class="badge bg-info"><?= $nama_jenis ?></span></td>
                        <td class="text-end"><?= number_format($jumlah, 0) ?></td>
                        <td class="text-end">Rp <?= number_format($harga_beli, 0, ',', '.') ?></td>
                        <td class="text-end">Rp <?= number_format($harga_jual, 0, ',', '.') ?></td>
                        <td class="text-end <?= $laba_per_unit >= 0 ? 'text-success' : 'text-danger' ?>">
                            Rp <?= number_format($laba_per_unit, 0, ',', '.') ?>
                        </td>
                        <td class="text-end"><strong>Rp <?= number_format($total_penjualan_item, 0, ',', '.') ?></strong></td>
                        <td class="text-end">Rp <?= number_format($total_hpp_item, 0, ',', '.') ?></td>
                        <td class="text-end">
                            <span class="badge bg-<?= $laba_rugi_item >= 0 ? 'success' : 'danger' ?>">
                                Rp <?= number_format($laba_rugi_item, 0, ',', '.') ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <span class="badge bg-<?= $margin >= 20 ? 'success' : ($margin >= 10 ? 'warning' : 'danger') ?>">
                                <?= number_format($margin, 1) ?>%
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-active">
                    <tr>
                        <td colspan="5" class="text-end"><strong>GRAND TOTAL:</strong></td>
                        <td class="text-end"><strong><?= number_format($total_barang_terjual, 0) ?></strong></td>
                        <td colspan="3"></td>
                        <td class="text-end"><strong>Rp <?= number_format($table_total_penjualan, 0, ',', '.') ?></strong></td>
                        <td class="text-end"><strong>Rp <?= number_format($table_total_hpp, 0, ',', '.') ?></strong></td>
                        <td class="text-end">
                            <strong>
                                <span class="badge bg-<?= $table_total_laba >= 0 ? 'success' : 'danger' ?>">
                                    Rp <?= number_format($table_total_laba, 0, ',', '.') ?>
                                </span>
                            </strong>
                        </td>
                        <td class="text-end">
                            <strong>
                                <span class="badge bg-<?= ($table_total_laba / ($table_total_penjualan > 0 ? $table_total_penjualan : 1) * 100) >= 20 ? 'success' : (($table_total_laba / ($table_total_penjualan > 0 ? $table_total_penjualan : 1) * 100) >= 10 ? 'warning' : 'danger') ?>">
                                    <?= $table_total_penjualan > 0 ? number_format(($table_total_laba / $table_total_penjualan) * 100, 1) : 0 ?>%
                                </span>
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Ringkasan dan Analisis -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5><i class="fas fa-chart-pie"></i> Analisis Laba Rugi</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="border rounded p-3 bg-light">
                            <h4 class="text-primary"><?= $jumlah_jenis_barang ?></h4>
                            <small class="text-muted">Jenis Barang</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-3 bg-light">
                            <h4 class="text-success"><?= $total_penjualan > 0 ? number_format(($total_laba_rugi / $total_penjualan) * 100, 1) : 0 ?>%</h4>
                            <small class="text-muted">Margin Laba</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-3 bg-light">
                            <h4 class="text-info">Rp <?= number_format($total_penjualan > 0 ? $total_penjualan / $total_barang_terjual : 0, 0, ',', '.') ?></h4>
                            <small class="text-muted">Rata-rata per Item</small>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6>Kinerja Laba Rugi:</h6>
                    <div class="progress mb-2" style="height: 20px;">
                        <div class="progress-bar bg-<?= ($total_laba_rugi / ($total_penjualan > 0 ? $total_penjualan : 1) * 100) >= 15 ? 'success' : (($total_laba_rugi / ($total_penjualan > 0 ? $total_penjualan : 1) * 100) >= 5 ? 'warning' : 'danger') ?>" 
                             style="width: <?= min(($total_laba_rugi / ($total_penjualan > 0 ? $total_penjualan : 1) * 100), 100) ?>%">
                            Margin: <?= $total_penjualan > 0 ? number_format(($total_laba_rugi / $total_penjualan) * 100, 1) : 0 ?>%
                        </div>
                    </div>
                    <small class="text-muted">
                        Target margin sehat: >15% (Hijau), Cukup: 5-15% (Kuning), Perlu perbaikan: <5% (Merah)
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5><i class="fas fa-info-circle"></i> Informasi Laporan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Periode Laporan:</strong></td>
                        <td><?= $bulan_list[$bulan_selected] ?> <?= $tahun_selected ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Generate:</strong></td>
                        <td><?= date('d/m/Y H:i:s') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Total Transaksi:</strong></td>
                        <td><?= count($laba_rugi) ?> transaksi</td>
                    </tr>
                    <tr>
                        <td><strong>Status Laba/Rugi:</strong></td>
                        <td>
                            <span class="badge bg-<?= $total_laba_rugi >= 0 ? 'success' : 'danger' ?>">
                                <?= $total_laba_rugi >= 0 ? 'LABA' : 'RUGI' ?> 
                                (Rp <?= number_format(abs($total_laba_rugi), 0, ',', '.') ?>)
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Efisiensi HPP:</strong></td>
                        <td>
                            <span class="badge bg-<?= ($total_harga_beli / ($total_penjualan > 0 ? $total_penjualan : 1) * 100) <= 70 ? 'success' : (($total_harga_beli / ($total_penjualan > 0 ? $total_penjualan : 1) * 100) <= 85 ? 'warning' : 'danger') ?>">
                                HPP <?= $total_penjualan > 0 ? number_format(($total_harga_beli / $total_penjualan) * 100, 1) : 0 ?>%
                            </span>
                        </td>
                    </tr>
                </table>
                
                <div class="d-grid gap-2">
                    <a href="<?= base_url('laporan/print_laba_rugi/'.$bulan_selected.'/'.$tahun_selected) ?>" class="btn btn-primary" target="_blank">
                        <i class="fas fa-print"></i> Print Laporan Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php elseif (isset($laba_rugi) && empty($laba_rugi)): ?>
<div class="card mt-4">
    <div class="card-body text-center py-5">
        <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
        <h4>Data laba rugi tidak ditemukan</h4>
        <p class="text-muted">Tidak ada data transaksi untuk periode <?= $bulan_list[$bulan_selected] ?> <?= $tahun_selected ?>.</p>
        <a href="<?= base_url('laporan/laba_rugi') ?>" class="btn btn-primary">
            <i class="fas fa-refresh"></i> Tampilkan Semua Data
        </a>
    </div>
</div>
<?php endif; ?>

<!-- JavaScript untuk meningkatkan UX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const bulanSelect = document.querySelector('select[name="bulan"]');
    const tahunSelect = document.querySelector('select[name="tahun"]');
    const jenisSelect = document.querySelector('select[name="jenis_barang"]');
    
    [bulanSelect, tahunSelect, jenisSelect].forEach(select => {
        select.addEventListener('change', function() {
            if (bulanSelect.value && tahunSelect.value) {
                this.form.submit();
            }
        });
    });
    

    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!bulanSelect.value || !tahunSelect.value) {
            e.preventDefault();
            alert('Silakan pilih bulan dan tahun terlebih dahulu!');
        }
    });
});
</script>