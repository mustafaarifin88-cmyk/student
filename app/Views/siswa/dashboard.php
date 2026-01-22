<?= $this->extend('layouts/siswa_main') ?>

<?= $this->section('content') ?>
<style>
    .welcome-card {
        background: url('<?= base_url('assets/dist/img/photo4.jpg') ?>') no-repeat center center;
        background-size: cover;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        color: white;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        height: 180px;
    }
    .welcome-overlay {
        background: linear-gradient(90deg, rgba(78, 84, 200, 0.9) 0%, rgba(143, 148, 251, 0.8) 100%);
        padding: 0 2rem;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
    }
    
    .stat-card {
        border-radius: 15px;
        padding: 1.2rem;
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .bg-rank-kelas { 
        background: linear-gradient(135deg, #3a7bd5 0%, #3a6073 100%); 
    }
    .bg-rank-sekolah { 
        background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%); 
    }
    .bg-poin { 
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); 
    }
    
    .card-label {
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        font-size: 0.75rem;
        opacity: 0.9;
        margin-bottom: 5px;
    }
    
    .rank-number {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.1;
        margin: 5px 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.15);
        display: flex;
        align-items: baseline;
    }

    .total-number {
        font-size: 1.2rem;
        font-weight: 400;
        opacity: 0.7;
        margin-left: 5px;
    }

    .stat-icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 6rem;
        opacity: 0.15;
        transform: rotate(-15deg);
    }

    .sub-text {
        font-size: 0.8rem;
        opacity: 0.9;
        font-weight: 400;
    }

    .medal-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border-radius: 50px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        margin-top: 5px;
        width: fit-content;
    }
    
    .leader-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        padding: 1.5rem;
        text-align: center;
        border: 1px solid #f0f0f0;
        height: 100%;
    }
    .leader-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        object-fit: cover;
        margin-bottom: 0.8rem;
    }
    .crown-icon {
        font-size: 1.8rem;
        color: #FFD700;
        margin-bottom: -15px;
        z-index: 2;
        position: relative;
    }
    
    .medal-animated {
        font-size: 7rem;
        animation: float-medal 3s ease-in-out infinite;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));
    }
    @keyframes float-medal {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
    }
    .text-gold { color: #FFD700; text-shadow: 0 2px 10px rgba(255, 215, 0, 0.5); }
    .text-silver { color: #E0E0E0; text-shadow: 0 2px 10px rgba(224, 224, 224, 0.5); }
    .text-bronze { color: #CD7F32; text-shadow: 0 2px 10px rgba(205, 127, 50, 0.5); }
</style>

<div class="row animate-pop">
    <div class="col-12">
        <div class="welcome-card">
            <div class="welcome-overlay">
                <div class="row w-100 align-items-center">
                    <div class="col-md-9">
                        <h2 class="font-weight-bold mb-1">Assalamualaikum, <?= $siswa['nama_lengkap'] ?>! 👋</h2>
                        <p class="mb-3 small" style="opacity: 0.9;">
                            <?= !empty($siswa['pesan_motivasi']) ? $siswa['pesan_motivasi'] : 'Ayo kumpulkan poin hari ini!' ?>
                        </p>
                        <a href="<?= base_url('siswa/tugas') ?>" class="btn btn-sm btn-light rounded-pill px-4 font-weight-bold text-primary shadow-sm">
                            Lihat Tugas
                        </a>
                    </div>
                    <div class="col-md-3 text-center d-none d-md-block">
                        <?php 
                            $medalColor = '';
                            $showMedal = false;
                            
                            if ($rank_kelas == 1) { $medalColor = 'text-gold'; $showMedal = true; } 
                            elseif ($rank_kelas == 2) { $medalColor = 'text-silver'; $showMedal = true; } 
                            elseif ($rank_kelas == 3) { $medalColor = 'text-bronze'; $showMedal = true; }
                        ?>

                        <?php if ($showMedal): ?>
                            <div class="medal-wrapper">
                                <i class="fas fa-medal medal-animated <?= $medalColor ?>"></i>
                                <div class="mt-3 font-weight-bold text-primary badge badge-light rounded-pill px-3 shadow-sm" style="font-size: 1rem; opacity: 0.9;">
                                    Juara <?= $rank_kelas ?> Kelas
                                </div>
                            </div>
                        <?php else: ?>
                            <i class="fas fa-user-graduate fa-6x text-white-50" style="filter: drop-shadow(0 0 10px rgba(255,255,255,0.3));"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stat-card bg-rank-kelas">
            <i class="fas fa-chalkboard-teacher stat-icon-bg"></i>
            <div>
                <div class="card-label"><i class="fas fa-layer-group mr-1"></i> Ranking Kelas</div>
                <div class="rank-number">
                    <?= $rank_kelas ?>
                    <span class="total-number">/ <?= $total_siswa_kelas ?></span>
                </div>
                <div class="sub-text">Posisi di kelas <?= $siswa['nama_kelas'] ?? '' ?></div>
            </div>
            
            <?php if($rank_kelas <= 3): ?>
                <div class="medal-badge">
                    <i class="fas fa-trophy mr-1 <?= $rank_kelas == 1 ? 'text-warning' : ($rank_kelas == 2 ? 'text-light' : 'text-orange') ?>"></i> 
                    Juara <?= $rank_kelas ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stat-card bg-rank-sekolah">
            <i class="fas fa-school stat-icon-bg"></i>
            <div>
                <div class="card-label"><i class="fas fa-university mr-1"></i> Ranking Sekolah</div>
                <div class="rank-number">
                    <?= $rank_sekolah ?>
                    <span class="total-number">/ <?= $total_siswa_sekolah ?></span>
                </div>
                <div class="sub-text">Tingkat satu sekolah</div>
            </div>

            <?php if($rank_sekolah <= 3): ?>
                <div class="medal-badge">
                    <i class="fas fa-medal mr-1 <?= $rank_sekolah == 1 ? 'text-warning' : ($rank_sekolah == 2 ? 'text-light' : 'text-orange') ?>"></i> 
                    Top 3 Sekolah
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card bg-poin">
            <i class="fas fa-star stat-icon-bg"></i>
            <div>
                <div class="card-label"><i class="fas fa-coins mr-1"></i> Total Poin</div>
                <div class="rank-number"><?= number_format($siswa['total_poin']) ?></div>
                <div class="sub-text">Poin keaktifan terkumpul</div>
            </div>
            <div class="medal-badge">
                <i class="fas fa-fire mr-1 text-warning"></i> Keep Going!
            </div>
        </div>
    </div>
</div>

<h6 class="font-weight-bold text-gray-600 mb-3 mt-4 px-1 text-uppercase small" style="letter-spacing: 1px;">
    <i class="fas fa-crown text-warning mr-2"></i> Hall of Fame
</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="leader-card">
            <div class="crown-icon"><i class="fas fa-crown"></i></div>
            <div class="small font-weight-bold text-gray-500 mb-3 text-uppercase">Juara 1 Kelasmu</div>
            
            <?php if ($top_siswa_kelas): ?>
                <?php $foto = $top_siswa_kelas['foto'] ? $top_siswa_kelas['foto'] : 'default.png'; ?>
                <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="leader-avatar" alt="Top Class">
                <h5 class="font-weight-bold text-dark mb-0"><?= $top_siswa_kelas['nama_lengkap'] ?></h5>
                <small class="text-muted d-block mb-2"><?= $top_siswa_kelas['nama_kelas'] ?? '-' ?></small>
                <span class="badge badge-pill badge-primary px-3">
                    <i class="fas fa-star mr-1 text-warning"></i> <?= $top_siswa_kelas['total_poin'] ?> Poin
                </span>
            <?php else: ?>
                <p class="text-muted small">Belum ada data.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="leader-card" style="border: 1px solid #FFD700;">
            <div class="crown-icon"><i class="fas fa-crown fa-lg"></i></div>
            <div class="small font-weight-bold text-gray-500 mb-3 text-uppercase">Juara 1 Sekolah</div>
            
            <?php if ($top_siswa_sekolah): ?>
                <?php $foto = $top_siswa_sekolah['foto'] ? $top_siswa_sekolah['foto'] : 'default.png'; ?>
                <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="leader-avatar" alt="Top School" style="border-color: #FFD700;">
                <h5 class="font-weight-bold text-dark mb-0"><?= $top_siswa_sekolah['nama_lengkap'] ?></h5>
                <small class="text-muted d-block mb-2"><?= $top_siswa_sekolah['nama_kelas'] ?? '-' ?></small>
                <span class="badge badge-pill badge-warning text-white px-3" style="background-color: #f39c12;">
                    <i class="fas fa-trophy mr-1"></i> <?= $top_siswa_sekolah['total_poin'] ?> Poin
                </span>
            <?php else: ?>
                <p class="text-muted small">Belum ada data.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>