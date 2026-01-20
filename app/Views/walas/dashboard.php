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
    .bg-gradient-walas {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; }
    .bg-soft-warning { background-color: rgba(246, 194, 62, 0.1); color: #f6c23e; }
    
    .action-btn {
        border-radius: 15px;
        transition: all 0.2s;
        border: 1px solid #f0f0f0;
        background: white;
    }
    .action-btn:hover {
        background-color: #f8f9fc;
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .class-badge {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(5px);
    }
</style>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card bg-gradient-walas text-white shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="row align-items-center position-relative" style="z-index: 1;">
                    <div class="col-md-8">
                        <h2 class="font-weight-bold mb-2">Halo, <?= session()->get('nama_lengkap') ?>!</h2>
                        <p class="mb-3 text-white-50">Selamat datang di panel Wali Kelas. Kelola aktivitas dan pantau perkembangan siswa Anda disini.</p>
                        
                        <?php if ($kelas): ?>
                            <div class="d-inline-flex align-items-center class-badge px-3 py-2 rounded-pill">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>
                                <span class="font-weight-bold">Wali Kelas <?= $nama_kelas ?></span>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-dark d-inline-block mb-0 rounded-pill px-4 py-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Anda belum ditugaskan di kelas manapun.
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 text-right d-none d-md-block">
                        <i class="fas fa-user-graduate fa-5x text-white-50" style="opacity: 0.3;"></i>
                    </div>
                </div>
                
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -30px; right: 100px; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 py-2 hover-card" style="border-radius: 20px; border-left: 5px solid #1cc88a;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Siswa Binaan</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $total_siswa ?> <span class="text-xs text-muted font-weight-normal">Siswa</span></div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-box bg-soft-success">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 py-2 hover-card" style="border-radius: 20px; border-left: 5px solid #4e73df;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Kegiatan</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $total_kegiatan ?> <span class="text-xs text-muted font-weight-normal">Tugas</span></div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-box bg-soft-primary">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 py-2 hover-card" style="border-radius: 20px; border-left: 5px solid #f6c23e;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Laporan Kelas</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">Lihat Ranking</div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-box bg-soft-warning">
                            <i class="fas fa-trophy fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4 h-100" style="border-radius: 20px;">
            <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between" style="border-radius: 20px 20px 0 0;">
                <h6 class="m-0 font-weight-bold text-success">Menu Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('walas/kegiatan/create') ?>" class="action-btn d-flex align-items-center p-3 text-decoration-none h-100">
                            <div class="icon-box bg-success text-white mr-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark m-0">Buat Kegiatan Baru</h6>
                                <small class="text-muted">Tambah tugas atau aktivitas untuk siswa</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('walas/siswa') ?>" class="action-btn d-flex align-items-center p-3 text-decoration-none h-100">
                            <div class="icon-box bg-primary text-white mr-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark m-0">Kelola Data Siswa</h6>
                                <small class="text-muted">Update data siswa di kelas Anda</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('walas/laporan/kegiatan') ?>" class="action-btn d-flex align-items-center p-3 text-decoration-none h-100">
                            <div class="icon-box bg-info text-white mr-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark m-0">Laporan Aktivitas</h6>
                                <small class="text-muted">Pantau siswa yang mengerjakan tugas</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="<?= base_url('walas/laporan/ranking') ?>" class="action-btn d-flex align-items-center p-3 text-decoration-none h-100">
                            <div class="icon-box bg-warning text-white mr-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark m-0">Ranking Kelas</h6>
                                <small class="text-muted">Lihat peringkat poin siswa</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4 h-100" style="border-radius: 20px;">
            <div class="card-header py-3 bg-white" style="border-radius: 20px 20px 0 0;">
                <h6 class="m-0 font-weight-bold text-success">Identitas Kelas</h6>
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-center">
                <?php if ($kelas): ?>
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center bg-soft-success rounded-circle" style="width: 100px; height: 100px;">
                            <i class="fas fa-layer-group fa-3x"></i>
                        </div>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-1"><?= $nama_kelas ?></h3>
                    <p class="text-muted mb-4">Tahun Ajaran Aktif</p>
                    <a href="<?= base_url('walas/siswa') ?>" class="btn btn-success rounded-pill px-4">
                        Lihat Detail Kelas
                    </a>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-ban fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Anda belum memiliki kelas.</p>
                        <small class="d-block text-gray-500">Hubungi Administrator untuk assignment kelas.</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>