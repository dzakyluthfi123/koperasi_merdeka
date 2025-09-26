<div class="container mt-4">
    <div class="row justify-content-center align-items-center min-vh-80">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Bagian Kiri - Form Register -->
                        <div class="col-md-6">
                            <div class="p-4">
                                <div class="text-center mb-3">
                                    <h4 class="fw-bold text-primary">Register Sistem</h4>
                                    <p class="text-muted small">Daftar akun baru</p>
                                </div>

                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                                        <small><?= $this->session->flashdata('error') ?></small>
                                        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                                        <small><?= $this->session->flashdata('success') ?></small>
                                        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('auth/proses_register') ?>" method="post">
                                    <div class="mb-2">
                                        <label for="nama_lengkap" class="form-label small fw-semibold">
                                            <i class="fas fa-user me-1"></i>Nama Lengkap
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="nama_lengkap" name="nama_lengkap" 
                                               placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="username" class="form-label small fw-semibold">
                                            <i class="fas fa-at me-1"></i>Username
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="username" name="username" 
                                               placeholder="Masukkan username" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="email" class="form-label small fw-semibold">
                                            <i class="fas fa-envelope me-1"></i>Email
                                        </label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email" 
                                               placeholder="Masukkan email" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="password" class="form-label small fw-semibold">
                                            <i class="fas fa-lock me-1"></i>Password
                                        </label>
                                        <input type="password" class="form-control form-control-sm" id="password" name="password" 
                                               placeholder="Masukkan password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label small fw-semibold">
                                            <i class="fas fa-lock me-1"></i>Konfirmasi Password
                                        </label>
                                        <input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password" 
                                               placeholder="Konfirmasi password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2">
                                        <i class="fas fa-user-plus me-1"></i>Daftar
                                    </button>
                                </form>

                                <div class="text-center mt-3">
                                    <p class="mb-0 small">Sudah punya akun? 
                                        <a href="<?= base_url('auth/login') ?>" class="text-decoration-none fw-bold">
                                            Login di sini
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Kanan - Logo Koperasi -->
                        <div class="col-md-6 bg-primary text-white">
                            <div class="p-4 d-flex flex-column justify-content-center align-items-center h-100">
                                <!-- Logo Koperasi -->
                                <div class="text-center mb-3">
                                    <div class="bg-white rounded-circle p-3 mb-2 shadow" style="width: 80px; height: 80px;">
                                        <i class="fas fa-handshake fa-2x text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">KOPERASI KELURAHAN </h5>
                                    <h5 class="fw-bold">MERAH PUTIH PROCOT</h5>
                                </div>

                                <!-- Informasi Koperasi -->
                                <div class="text-center mt-3">
                                    <p class="mb-1 small">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Jl. Koperasi No. 123, Jakarta
                                    </p>
                                    <p class="mb-1 small">
                                        <i class="fas fa-phone me-1"></i>
                                        (021) 1234-5678
                                    </p>
                                    <p class="mb-0 small">
                                        <i class="fas fa-envelope me-1"></i>
                                        info@koperasi-sejahtera.com
                                    </p>
                                </div>

                                <!-- Moto atau Slogan -->
                                <div class="text-center mt-3">
                                    <blockquote class="blockquote mb-0">
                                        <p class="mb-0 fst-italic small">
                                            <i class="fas fa-quote-left me-1"></i>
                                            Dari anggota, oleh anggota, untuk anggota
                                            <i class="fas fa-quote-right ms-1"></i>
                                        </p>
                                        <footer class="blockquote-footer text-white-50 mt-1 small">Moto Koperasi Kami</footer>
                                    </blockquote>
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
    min-height: 70vh;
}
.card {
    border: none;
    border-radius: 12px;
}
.bg-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    border-radius: 0 12px 12px 0;
}
.form-control {
    border-radius: 8px;
    border: 1.5px solid #e9ecef;
    transition: all 0.3s;
    font-size: 0.875rem;
}
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.btn-primary {
    border-radius: 8px;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    transition: all 0.3s;
    font-size: 0.875rem;
}
.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
}
.small {
    font-size: 0.8rem;
}
</style>