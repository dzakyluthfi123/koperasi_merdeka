<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Bulanan - Koperasi Merdeka</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            font-size: 14px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 { 
            margin: 0; 
            color: #333;
        }
        .header p { 
            margin: 5px 0; 
            color: #666;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
            font-size: 12px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .total { 
            font-weight: bold; 
            background-color: #e9e9e9; 
        }
        .text-right { 
            text-align: right; 
        }
        .text-center { 
            text-align: center; 
        }
        .footer { 
            margin-top: 30px; 
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 10px;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        @media print {
            .no-print { 
                display: none; 
            }
            body { 
                margin: 0; 
            }
            .header {
                margin-top: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>KOPERASI MERDEKA</h2>
        <p>Laporan Penjualan Bulan <?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) ?></p>
        <p>Tanggal Cetak: <?= date('d/m/Y H:i:s') ?></p>
    </div>
    
    <?php
    $bulan_list = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    ?>
    
    <?php if ($penjualan): ?>
    <div class="summary">
        <p><strong>Periode:</strong> <?= $bulan_list[$bulan] ?> <?= $tahun ?></p>
        <p><strong>Total Pendapatan:</strong> Rp <?= number_format($total ? $total->total_penjualan : 0, 0, ',', '.') ?></p>
        <p><strong>Total Barang Terjual:</strong> <?= $total ? $total->total_barang_terjual : 0 ?> item</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah Terjual</th>
                <th>Harga Jual</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $grand_total = 0;
            foreach($penjualan as $p): 
                $grand_total += $p->total_pendapatan;
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= date('d/m/Y', strtotime($p->tanggal_keluar)) ?></td>
                <td><?= $p->nama_barang ?></td>
                <td><?= $p->nama_jenis ?></td>
                <td class="text-center"><?= $p->total_terjual ?></td>
                <td class="text-right">Rp <?= number_format($p->rata_harga_jual, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($p->total_pendapatan, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="6" class="text-right"><strong>TOTAL PENJUALAN</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($grand_total, 0, ',', '.') ?></strong></td>
            </tr>
        </tfoot>
    </table>
    
    <?php else: ?>
    <div style="text-align: center; padding: 40px;">
        <p><strong>Tidak ada data penjualan untuk periode yang dipilih.</strong></p>
    </div>
    <?php endif; ?>
    
    <div class="footer">
        <table width="100%">
            <tr>
                <td width="50%" class="text-center">
                    <p>Mengetahui,</p>
                    <br><br><br>
                    <p><strong>Manager Koperasi</strong></p>
                </td>
                <td width="50%" class="text-center">
                    <p>Yang Membuat,</p>
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
    
    <script>
        window.onload = function() {
            // Auto print jika diinginkan
            // window.print();
        }
    </script>
</body>
</html>