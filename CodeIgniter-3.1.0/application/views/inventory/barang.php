<div class="d-flex justify-content-between mb-3">
    <h3>Data Barang</h3>
    <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Barang
    </a>
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
            <table class="table table-striped" id="tableBarang">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($barang as $b): ?>
                    <tr>
                        <td><?= $no++ ?></td>
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
                        <td>
                            <a href="<?= base_url('barang/edit/'.$b->id) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('barang/hapus/'.$b->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus barang?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tableBarang').DataTable();
    });
</script>