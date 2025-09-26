<div class="d-flex justify-content-between mb-3">
    <h3>Jenis Barang</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJenisModal">
        <i class="fas fa-plus"></i> Tambah Jenis
    </button>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Jenis</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($jenis as $j): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $j->nama_jenis ?></td>
                        <td><?= $j->deskripsi ?></td>
                        <td><?= date('d/m/Y', strtotime($j->created_at)) ?></td>
                        <td>
                            <!-- <button class="btn btn-warning btn-sm edit-jenis" data-id="<?= $j->id ?>" data-nama="<?= $j->nama_jenis ?>" data-deskripsi="<?= $j->deskripsi ?>">
                                <i class="fas fa-edit"></i>
                            </button> -->
                            <a href="<?= base_url('jenis/hapus/'.$j->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus jenis barang?')">
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

<!-- Modal Tambah Jenis -->
<div class="modal fade" id="tambahJenisModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= base_url('jenis-barang') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis</label>
                        <input type="text" class="form-control" name="nama_jenis" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3"></textarea>
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

<!-- Modal Edit Jenis -->
<div class="modal fade" id="editJenisModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= base_url('jenis/update') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jenis Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis</label>
                        <input type="text" class="form-control" name="nama_jenis" id="edit_nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.edit-jenis').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var deskripsi = $(this).data('deskripsi');
            
            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_deskripsi').val(deskripsi);
            
            $('#editJenisModal').modal('show');
        });
    });
</script>