<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .bg-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #36b9cc; }
    
    .action-btn {
        border-radius: 15px;
        transition: all 0.2s;
        border: 1px solid #f0f0f0;
    }
    .action-btn:hover {
        background-color: #f8f9fc;
        transform: scale(1.02);
    }
</style>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white shadow-lg" style="border-radius: 20px; background: linear-gradient(45deg, #4e73df, #224abe);">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="row align-items-center position-relative" style="z-index: 1;">
                    <div class="col-md-8">
                        <h2 class="font-weight-bold mb-2">Selamat Datang, Admin!</h2>
                        <p class="mb-0 text-white-50">Kelola data sekolah, guru, dan aktivitas siswa dalam satu panel terintegrasi.</p>
                    </div>
                    <div class="col-md-4 text-right d-none d-md-block">
                        <i class="fas fa-chart-pie fa-4x text-white-50"></i>
                    </div>
                </div>
                <div style="position: absolute; top: -30px; right: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -50px; right: 80px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 py-2 hover-card" style="border-radius: 20px; border-left: 5px solid #4e73df;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Guru</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $total_guru ?></div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-box bg-soft-primary">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 py-2 hover-card" style="border-radius: 20px; border-left: 5px solid #1cc88a;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Siswa</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $total_siswa ?></div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-box bg-soft-success">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 py-2 hover-card" style="border-radius: 20px; border-left: 5px solid #36b9cc;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Kelas</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $total_kelas ?></div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-box bg-soft-info">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4 h-100" style="border-radius: 20px;">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white" style="border-radius: 20px 20px 0 0;">
                <h6 class="m-0 font-weight-bold text-primary">Profil Sekolah</h6>
                <a href="<?= base_url('admin/sekolah') ?>" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
            </div>
            <div class="card-body text-center">
                <?php if ($sekolah): ?>
                    <img src="<?= base_url('uploads/sekolah/' . $sekolah['logo']) ?>" 
                         class="img-fluid rounded-circle shadow-sm mb-3" 
                         style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #f8f9fc;"
                         onerror="this.src='<?= base_url('assets/dist/img/AdminLTELogo.png') ?>'">
                    <h4 class="font-weight-bold text-dark mb-1"><?= $sekolah['nama_sekolah'] ?></h4>
                    <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt text-danger mr-1"></i> <?= $sekolah['alamat'] ?></p>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-school fa-3x mb-3 text-gray-300"></i>
                        <p>Data sekolah belum diatur.</p>
                        <a href="<?= base_url('admin/sekolah') ?>" class="btn btn-primary btn-sm mt-2 rounded-pill">Atur Sekarang</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4 h-100" style="border-radius: 20px;">
            <div class="card-header py-3 bg-white" style="border-radius: 20px 20px 0 0;">
                <h6 class="m-0 font-weight-bold text-primary">Akses Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('admin/siswa/create') ?>" class="action-btn d-block p-3 text-center text-decoration-none">
                            <i class="fas fa-user-plus fa-2x text-success mb-2"></i>
                            <h6 class="font-weight-bold text-dark m-0 small">Tambah Siswa</h6>
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="<?= base_url('admin/guru/create') ?>" class="action-btn d-block p-3 text-center text-decoration-none">
                            <i class="fas fa-chalkboard-teacher fa-2x text-primary mb-2"></i>
                            <h6 class="font-weight-bold text-dark m-0 small">Tambah Guru</h6>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/kelas') ?>" class="action-btn d-block p-3 text-center text-decoration-none">
                            <i class="fas fa-th-list fa-2x text-info mb-2"></i>
                            <h6 class="font-weight-bold text-dark m-0 small">Data Kelas</h6>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/laporan/kegiatan') ?>" class="action-btn d-block p-3 text-center text-decoration-none">
                            <i class="fas fa-file-alt fa-2x text-warning mb-2"></i>
                            <h6 class="font-weight-bold text-dark m-0 small">Laporan</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>