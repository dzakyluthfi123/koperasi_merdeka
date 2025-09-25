<div class="d-flex justify-content-between mb-3">
    <h3>Tambah Barang</h3>
    <a href="<?= base_url('barang') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= base_url('barang/tambah') ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" name="kode_barang" value="<?= 'BRG-'.date('YmdHis') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Barang</label>
                        <select class="form-control" name="id_jenis" required>
                            <option value="">Pilih Jenis</option>
                            <?php foreach($jenis as $j): ?>
                            <option value="<?= $j->id ?>"><?= $j->nama_jenis ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" class="form-control" name="satuan" placeholder="Contoh: pcs, kg, liter" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" class="form-control" name="stok" value="0" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" name="harga_beli" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" name="harga_jual" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Stok Minimum</label>
                        <input type="number" class="form-control" name="min_stok" value="5" required>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Barang
            </button>
        </form>
    </div>
</div>