<div class="container mt-5">
    <div class="row justify-content-center align-items-center min-vh-80">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Bagian Kiri - Form Login -->
                        <div class="col-md-6">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold text-primary">Login Sistem</h3>
                                    <p class="text-muted">Masuk ke akun Anda</p>
                                </div>

                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('error') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('success') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('auth/proses_login') ?>" method="post">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username atau Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   placeholder="Masukkan username atau email" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Masukkan password" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-2">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </button>
                                </form>

                                <div class="text-center mt-4">
                                    <p class="mb-0">Belum punya akun? 
                                        <a href="<?= base_url('auth/register') ?>" class="text-decoration-none fw-bold">
                                            Daftar di sini
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Kanan - Logo Koperasi -->
                        <div class="col-md-6 bg-primary text-white position-relative">
                            <div class="p-5 d-flex flex-column justify-content-center align-items-center h-100">
                                <!-- Logo dengan gambar -->
                                <div class="text-center mb-4">
                                    <?php if (file_exists(FCPATH . 'assets/image.jpg')): ?>
                                        <img src="<?= base_url('assets/image.jpg') ?>" 
                                             alt="Logo Koperasi" 
                                             class="img-fluid mb-3" 
                                             style="max-height: 150px;">
                                    <?php else: ?>
                                        <div class="bg-white rounded-circle p-4 mb-3 shadow" style="width: 120px; height: 120px;">
                                            <i class="fas fa-handshake fa-3x text-primary"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h2 class="fw-bold">KOPERASI KELURAHAN MERAH PUTIH PROCOT</h2>
                                    <p class="lead">Sejahtera Bersama Membangun Ekonomi</p>
                                </div>

                                <!-- Fitur Koperasi
                                <div class="row text-center mt-4">
                                    <div class="col-6 mb-3">
                                        <i class="fas fa-users fa-2x mb-2"></i>
                                        <h6>Anggota Aktif</h6>
                                        <small>500+ Anggota</small>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <i class="fas fa-chart-line fa-2x mb-2"></i>
                                        <h6>Profit Sharing</h6>
                                        <small>Bagi Hasil</small>
                                    </div>
                                </div> -->

                                <!-- Copyright -->
                                <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3">
                                    <small>&copy; 2025 Koperasi Merah Putih Procot.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.min-vh-80 {
    min-height: 80vh;
}
.card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
}
.bg-primary {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
}
.form-control {
    border-radius: 8px;
    border: 1px solid #ddd;
}
.input-group-text {
    background: #f8f9fa;
    border: 1px solid #ddd;
}
.btn-primary {
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border: none;
}
</style>