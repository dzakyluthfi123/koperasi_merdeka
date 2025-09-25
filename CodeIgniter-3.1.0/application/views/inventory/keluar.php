<div class="d-flex justify-content-between mb-3">
    <h3>Barang Keluar</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKeluarModal">
        <i class="fas fa-plus"></i> Tambah Barang Keluar
    </button>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($keluar as $k): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($k->tanggal_keluar)) ?></td>
                        <td><?= $k->kode_transaksi ?></td>
                        <td><?= $k->nama_barang ?></td>
                        <td><?= $k->jumlah ?></td>
                        <td>Rp <?= number_format($k->harga_jual, 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($k->total, 0, ',', '.') ?></td>
                        <td><?= $k->keterangan ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Barang Keluar -->
<div class="modal fade" id="tambahKeluarModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= base_url('barang-keluar') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih Barang</label>
                                <select class="form-control" name="id_barang" required>
                                    <option value="">Pilih Barang</option>
                                    <?php foreach($barang as $b): ?>
                                    <option value="<?= $b->id ?>" data-harga="<?= $b->harga_jual ?>" data-stok="<?= $b->stok ?>">
                                        <?= $b->nama_barang ?> (Stok: <?= $b->stok ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" required>
                                <small class="text-muted">Stok tersedia: <span id="stokTersedia">0</span></small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="number" class="form-control" name="harga_jual" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Keluar</label>
                                <input type="date" class="form-control" name="tanggal_keluar" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3" placeholder="Contoh: Penjualan, Sample, dll"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Total</label>
                                <input type="text" class="form-control" id="total_keluar" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('select[name="id_barang"]').change(function() {
            var harga = $(this).find(':selected').data('harga');
            var stok = $(this).find(':selected').data('stok');
            
            $('input[name="harga_jual"]').val(harga);
            $('#stokTersedia').text(stok);
            calculateTotal();
        });
        
        $('input[name="jumlah"], input[name="harga_jual"]').keyup(function() {
            calculateTotal();
        });
        
        function calculateTotal() {
            var jumlah = $('input[name="jumlah"]').val();
            var harga = $('input[name="harga_jual"]').val();
            var total = jumlah * harga;
            
            if (!isNaN(total)) {
                $('#total_keluar').val('Rp ' + total.toLocaleString('id-ID'));
            }
        }
    });
</script>