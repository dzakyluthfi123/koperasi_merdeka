<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laba Rugi - Koperasi Merah Putih Procot</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .total { font-weight: bold; background-color: #e9e9e9; }
        .footer { margin-top: 30px; text-align: center; border-top: 1px solid #333; padding-top: 10px; }
        .summary { background-color: #f8f9fa; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        @media print { .no-print { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="header">
        <h2>KOPERASI KELURAHAN MERAH PUTIH PROCOT</h2>
        <h3>LAPORAN LABA RUGI</h3>
        <p>Periode: <?= isset($bulan_list[$bulan]) ? $bulan_list[$bulan] . ' ' . $tahun : 'Bulan ' . $bulan . ' ' . $tahun ?></p>
        <p>Tanggal Cetak: <?= date('d/m/Y H:i:s') ?></p>
    </div>
    
    <?php if (!empty($laba_rugi)): 
        $total_penjualan = 0;
        $total_harga_beli = 0;
        $total_laba_rugi = 0;
        
        foreach($laba_rugi as $lr) {
            $total_penjualan += $lr->total_penjualan;
            $total_harga_beli += $lr->total_harga_beli;
            $total_laba_rugi += $lr->laba_rugi;
        }
    ?>
    
    <div class="summary">
        <p><strong>Total Penjualan:</strong> Rp <?= number_format($total_penjualan, 0, ',', '.') ?></p>
        <p><strong>Total Harga Beli:</strong> Rp <?= number_format($total_harga_beli, 0, ',', '.') ?></p>
        <p><strong>Total <?= $total_laba_rugi >= 0 ? 'Laba' : 'Rugi' ?>:</strong> 
            <span class="<?= $total_laba_rugi >= 0 ? 'text-success' : 'text-danger' ?>">
                Rp <?= number_format($total_laba_rugi, 0, ',', '.') ?>
            </span>
        </p>
        <p><strong>Margin:</strong> <?= number_format(($total_penjualan > 0 ? ($total_laba_rugi / $total_penjualan * 100) : 0), 1) ?>%</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
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
            <?php $no = 1; foreach($laba_rugi as $lr): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= date('d/m/Y', strtotime($lr->tanggal_keluar)) ?></td>
                <td><?= $lr->nama_barang ?></td>
                <td class="text-center"><?= $lr->jumlah ?></td>
                <td class="text-right">Rp <?= number_format($lr->harga_beli, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($lr->harga_jual, 0, ',', '.') ?></td>
                <td class="text-right <?= $lr->laba_per_unit >= 0 ? 'text-success' : 'text-danger' ?>">
                    Rp <?= number_format($lr->laba_per_unit, 0, ',', '.') ?>
                </td>
                <td class="text-right">Rp <?= number_format($lr->total_penjualan, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($lr->total_harga_beli, 0, ',', '.') ?></td>
                <td class="text-right <?= $lr->laba_rugi >= 0 ? 'text-success' : 'text-danger' ?>">
                    Rp <?= number_format($lr->laba_rugi, 0, ',', '.') ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="7" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></strong></td>
                <td class="text-right"><strong>Rp <?= number_format($total_harga_beli, 0, ',', '.') ?></strong></td>
                <td class="text-right <?= $total_laba_rugi >= 0 ? 'text-success' : 'text-danger' ?>">
                    <strong>Rp <?= number_format($total_laba_rugi, 0, ',', '.') ?></strong>
                </td>
            </tr>
        </tfoot>
    </table>
    
    <?php else: ?>
    <div style="text-align: center; padding: 40px;">
        <p><strong>Tidak ada data laba rugi untuk periode yang dipilih.</strong></p>
    </div>
    <?php endif; ?>
    
    <div class="footer">
        <table width="100%">
            <tr>
                <td width="50%" class="text-center">
                    <p>Mengetahui,</p>
                    <p>KETUA</p>
                    <br><br><br>
                    <p><strong><b>KARYOTO</b></strong></p>
                </td>
                <td width="50%" class="text-center">
                    <p>Yang Membuat,</p>
                    <p>BENDAHARA</p>
                    <br><br><br>
                    <p><strong>Administrator</strong></p>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" class="btn btn-primary">Print Laporan</button>
        <button onclick="window.history.back()" class="btn btn-secondary">Kembali</button>
    </div>
</body>
</html>