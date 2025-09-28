<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?php
    
    $bulan_list = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    
    
    $nama_bulan = isset($bulan) && isset($bulan_list[$bulan]) ? $bulan_list[$bulan] : 'Semua Bulan';
    $tahun = isset($tahun) ? $tahun : date('Y');
    
    
    if (!isset($bulan) || empty($bulan)) {
        $periode_text = "Tahun $tahun";
    } else {
        $periode_text = "$nama_bulan $tahun";
    }
    ?>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .table tfoot tr {
            background-color: #e3f2fd;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>KOPERASI KELURAHAN MERAH PUTIH PROCOT</h1>
        <h3>LAPORAN PENJUALAN</h3>
        <h3>Periode: <?= $periode_text ?></h3>
        <p>Dicetak pada: <?= date('d/m/Y') ?></p>
    </div>

    <?php if (!empty($penjualan)): ?>
        <?php 
        $grand_total = 0;
        foreach($penjualan as $p) {
            $grand_total += $p->total_pendapatan;
        }
        ?>
         <div class="summary">
            <h3>Ringkasan Laporan Penjualan Koperasi :</h3>
            <p><strong>Total Pembayaran:</strong> Rp <?= number_format($grand_total, 0, ',', '.') ?></p>
            <p><strong>Total Barang Terjual:</strong> <?= number_format($total->total_barang_terjual, 0, ',', '.') ?> unit</p>
            <p><strong>Jenis Barang Terjual:</strong> <?= $total->jumlah_jenis_barang ?> jenis</p>
            
        </div>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah Terjual</th>
                    <th>Harga Jual</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($penjualan as $p): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($p->tanggal_keluar)) ?></td>
                    <td><?= $p->nama_barang ?></td>
                    <td><?= $p->nama_jenis ?></td>
                    <td><?= number_format($p->total_terjual, 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($p->rata_harga_jual, 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($p->total_pendapatan, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><strong>Total Penjualan:</strong></td>
                    <td><strong>Rp <?= number_format($grand_total, 0, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>

       
        
    <?php else: ?>
        <div style="text-align: center; padding: 40px;">
            <h3>Data penjualan tidak ditemukan</h3>
            <p>Tidak ada data penjualan untuk periode <?= $nama_bulan ?> <?= $tahun ?></p>
        </div>
    <?php endif; ?>
</body>
</html>