<div class="d-flex justify-content-between mb-3">
    <h3>Barang Masuk</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMasukModal">
        <i class="fas fa-plus"></i> Tambah Barang Masuk
    </button>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<!-- Debug Info (bisa dihapus setelah fix) -->
<div class="alert alert-info">
    <strong>Debug Info:</strong><br>
    Jumlah Barang: <?= count($barang) ?><br>
    Jumlah Data Masuk: <?= count($masuk) ?>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($masuk)): ?>
            <div class="text-center py-4">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5>Belum ada data barang masuk</h5>
                <p class="text-muted">Silakan tambah data barang masuk pertama Anda.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Barang</th>
                            <th>Harga Beli</th>
                            <th>Total</th>
                            <th>Supplier</th>
                            <th>Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($masuk as $m): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($m->tanggal_masuk)) ?></td>
                            <td><?= $m->kode_transaksi ?></td>
                            <td><?= $m->nama_barang ?></td>
                            <td><?= $m->jumlah ?></td>
                            <td>Rp <?= number_format($m->harga_beli, 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($m->total, 0, ',', '.') ?></td>
                            <td><?= $m->supplier ?></td>
                            <td>
    <a href="<?= base_url('barang-masuk/hapus/'.$m->id) ?>" 
       class="btn btn-danger btn-sm btn-hapus" 
       data-kode="<?= $m->kode_transaksi ?>"
       title="Hapus Barang Masuk">
        <i class="fas fa-trash"></i>
    </a>
</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Barang Masuk -->
<div class="modal fade" id="tambahMasukModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= base_url('barang-masuk') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih Barang *</label>
                                <select class="form-control" name="id_barang" id="id_barang" required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?php if (!empty($barang)): ?>
                                        <?php foreach($barang as $b): ?>
                                            <option value="<?= $b->id ?>" 
                                                    data-harga="<?= $b->harga_beli ?>"
                                                    data-stok="<?= $b->stok ?>">
                                                <?= $b->kode_barang ?> - <?= $b->nama_barang ?> 
                                                (Stok: <?= $b->stok ?> <?= $b->satuan ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="">Tidak ada barang tersedia</option>
                                    <?php endif; ?>
                                </select>
                                <small class="text-muted">Pastikan barang sudah terdaftar di Data Barang</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Jumlah *</label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required>
                                <small class="text-muted">Stok saat ini: <span id="current_stok">0</span></small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Harga Beli per Unit *</label>
                                <input type="number" class="form-control" name="harga_beli" id="harga_beli" min="0" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Masuk *</label>
                                <input type="date" class="form-control" name="tanggal_masuk" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Supplier *</label>
                                <input type="text" class="form-control" name="supplier" placeholder="Nama supplier" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Total Biaya</label>
                                <input type="text" class="form-control bg-light" id="total_masuk" readonly>
                                <small class="text-muted">Jumlah × Harga Beli</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Barang Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi variabel
        var currentHarga = 0;
        var currentStok = 0;
        
        // Ketika barang dipilih
        $('#id_barang').change(function() {
            var selectedOption = $(this).find('option:selected');
            currentHarga = selectedOption.data('harga');
            currentStok = selectedOption.data('stok');
            
            // Set nilai harga beli
            $('#harga_beli').val(currentHarga);
            
            // Tampilkan stok saat ini
            $('#current_stok').text(currentStok);
            
            // Hitung total
            calculateTotal();
        });
        
        // Ketika jumlah atau harga berubah
        $('#jumlah, #harga_beli').on('input', function() {
            calculateTotal();
        });
        
        // Fungsi hitung total
        function calculateTotal() {
            var jumlah = parseInt($('#jumlah').val()) || 0;
            var harga = parseInt($('#harga_beli').val()) || 0;
            var total = jumlah * harga;
            
            // Format total dengan separator ribuan
            if (total > 0) {
                $('#total_masuk').val('Rp ' + total.toLocaleString('id-ID'));
            } else {
                $('#total_masuk').val('Rp 0');
            }
        }
        
        // Validasi form sebelum submit
        $('form').submit(function(e) {
            var idBarang = $('#id_barang').val();
            var jumlah = $('#jumlah').val();
            
            if (!idBarang) {
                alert('Pilih barang terlebih dahulu!');
                e.preventDefault();
                return false;
            }
            
            if (jumlah < 1) {
                alert('Jumlah harus lebih dari 0!');
                e.preventDefault();
                return false;
            }
        });

        // SweetAlert untuk konfirmasi hapus
        $('a[onclick*="confirm"]').click(function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            var kodeTransaksi = $(this).closest('tr').find('td:eq(2)').text().trim();
            
            Swal.fire({
                title: 'Hapus Barang Masuk?',
                html: `Yakin ingin menghapus data barang masuk dengan kode <strong>"${kodeTransaksi}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });
</script>

<!-- Include SweetAlert untuk konfirmasi yang lebih baik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>