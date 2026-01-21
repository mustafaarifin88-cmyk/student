<?= $this->extend('layouts/siswa_main') ?>

<?= $this->section('content') ?>
<style>
    .welcome-card {
        background: url('<?= base_url('assets/dist/img/photo4.jpg') ?>') no-repeat center center;
        background-size: cover;
        border-radius: 25px;
        position: relative;
        overflow: hidden;
        color: white;
        margin-bottom: 2rem;
    }
    .welcome-overlay {
        background: linear-gradient(90deg, rgba(106, 17, 203, 0.9) 0%, rgba(37, 117, 252, 0.8) 100%);
        padding: 3rem 2rem;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
    }
    .stat-card {
        border-radius: 20px;
        padding: 1.5rem;
        height: 100%;
        transition: transform 0.3s;
        border: none;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-10px);
    }
    .bg-gradient-gold { background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%); }
    .bg-gradient-silver { background: linear-gradient(135deg, #E0E0E0 0%, #BDBDBD 100%); }
    .bg-gradient-bronze { background: linear-gradient(135deg, #CD7F32 0%, #A0522D 100%); }
    .bg-gradient-blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .bg-gradient-purple { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
    
    .medal-img {
        width: 80px;
        filter: drop-shadow(0 5px 5px rgba(0,0,0,0.2));
        margin-bottom: 10px;
    }
    .rank-number {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    .leader-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 2rem;
        text-align: center;
        border: 2px solid #f0f0f0;
    }
    .leader-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        object-fit: cover;
        margin-bottom: 1rem;
    }
    .crown-icon {
        font-size: 2rem;
        color: #FFD700;
        margin-bottom: -15px;
        z-index: 2;
        position: relative;
    }
    .circle-bg-icon {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.2;
        transform: rotate(-15deg);
    }

    /* Animasi Medali */
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
        <div class="welcome-card shadow-lg">
            <div class="welcome-overlay">
                <div class="row w-100 align-items-center">
                    <div class="col-md-8">
                        <h1 class="font-weight-bold mb-2">Hai, <?= $siswa['nama_lengkap'] ?>! 👋</h1>
                        <p class="lead mb-4" style="opacity: 0.9;">Semangat belajar dan kumpulkan poin sebanyak-banyaknya hari ini!</p>
                        <a href="<?= base_url('siswa/tugas') ?>" class="btn btn-light rounded-pill px-4 py-2 font-weight-bold text-primary shadow">
                            <i class="fas fa-rocket mr-2"></i> Lihat Tugas Saya
                        </a>
                    </div>
                    <div class="col-md-4 text-center d-none d-md-block">
                        <?php 
                            $medalColor = '';
                            $showMedal = false;
                            
                            // Cek Ranking Kelas untuk Medali (1, 2, 3)
                            if ($rank_kelas == 1) { 
                                $medalColor = 'text-gold'; 
                                $showMedal = true;
                            } elseif ($rank_kelas == 2) { 
                                $medalColor = 'text-silver'; 
                                $showMedal = true;
                            } elseif ($rank_kelas == 3) { 
                                $medalColor = 'text-bronze'; 
                                $showMedal = true;
                            }
                        ?>

                        <?php if ($showMedal): ?>
                            <div class="medal-wrapper">
                                <i class="fas fa-medal medal-animated <?= $medalColor ?>"></i>
                                <!-- Perbaikan: Mengganti text-white menjadi text-primary agar terlihat di atas badge-light -->
                                <div class="mt-3 font-weight-bold text-primary badge badge-light rounded-pill px-3 shadow-sm" style="font-size: 1rem; opacity: 0.9;">
                                    Juara <?= $rank_kelas ?> Kelas
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Tampilkan ilustrasi semangat jika ranking > 3 -->
                            <i class="fas fa-user-graduate fa-6x text-white-50" style="filter: drop-shadow(0 0 10px rgba(255,255,255,0.3)); animation: float-medal 4s infinite;"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <?php 
            $bgClass = 'bg-gradient-blue';
            $medalIcon = '';
            // Ranking card tetap menampilkan info ranking
            if ($rank_kelas == 1) { $bgClass = 'bg-gradient-gold'; $medalIcon = '🥇'; }
            elseif ($rank_kelas == 2) { $bgClass = 'bg-gradient-silver'; $medalIcon = '🥈'; }
            elseif ($rank_kelas == 3) { $bgClass = 'bg-gradient-bronze'; $medalIcon = '🥉'; }
        ?>
        <div class="stat-card <?= $bgClass ?> shadow text-center">
            <i class="fas fa-chalkboard-teacher circle-bg-icon"></i>
            <h5 class="text-uppercase font-weight-bold mb-3" style="opacity: 0.9;">Ranking Kelas</h5>
            <?php if($medalIcon): ?>
                <div class="display-4"><?= $medalIcon ?></div>
            <?php endif; ?>
            <div class="rank-number"><?= $rank_kelas ?></div>
            <p class="mb-0 mt-2 font-weight-bold">Dari semua siswa di kelasmu</p>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <?php 
            $bgClassSekolah = 'bg-gradient-purple';
            $medalIconSekolah = '';
            if ($rank_sekolah == 1) { $bgClassSekolah = 'bg-gradient-gold'; $medalIconSekolah = '🥇'; }
            elseif ($rank_sekolah == 2) { $bgClassSekolah = 'bg-gradient-silver'; $medalIconSekolah = '🥈'; }
            elseif ($rank_sekolah == 3) { $bgClassSekolah = 'bg-gradient-bronze'; $medalIconSekolah = '🥉'; }
        ?>
        <div class="stat-card <?= $bgClassSekolah ?> shadow text-center">
            <i class="fas fa-school circle-bg-icon"></i>
            <h5 class="text-uppercase font-weight-bold mb-3" style="opacity: 0.9;">Ranking Sekolah</h5>
            <?php if($medalIconSekolah): ?>
                <div class="display-4"><?= $medalIconSekolah ?></div>
            <?php endif; ?>
            <div class="rank-number"><?= $rank_sekolah ?></div>
            <p class="mb-0 mt-2 font-weight-bold">Tingkat satu sekolah</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card bg-bubble-success shadow text-center">
            <i class="fas fa-star circle-bg-icon"></i>
            <h5 class="text-uppercase font-weight-bold mb-3" style="opacity: 0.9;">Total Poin Kamu</h5>
            <div class="rank-number"><?= number_format($siswa['total_poin']) ?></div>
            <div class="mt-2 badge badge-light text-success px-3 py-2 rounded-pill font-weight-bold" style="font-size: 1rem;">
                Keep Going! 🔥
            </div>
        </div>
    </div>
</div>

<h4 class="font-weight-bold text-gray-800 mb-3 mt-5 px-2 border-left-4 border-primary">
    <span style="border-left: 5px solid #6a11cb; padding-left: 10px;">Hall of Fame</span>
</h4>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="leader-card h-100">
            <div class="crown-icon"><i class="fas fa-crown"></i></div>
            <h5 class="font-weight-bold text-gray-600 mb-4">Juara 1 Di Kelasmu</h5>
            
            <?php if ($top_siswa_kelas): ?>
                <?php $foto = $top_siswa_kelas['foto'] ? $top_siswa_kelas['foto'] : 'default.png'; ?>
                <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="leader-avatar" alt="Top Class">
                <h4 class="font-weight-bold text-primary mb-1"><?= $top_siswa_kelas['nama_lengkap'] ?></h4>
                <p class="text-muted mb-3"><?= $top_siswa_kelas['nama_kelas'] ?></p>
                <div class="badge badge-warning text-white px-4 py-2 rounded-pill shadow-sm" style="background: #f1c40f; font-size: 1rem;">
                    <i class="fas fa-star mr-1"></i> <?= $top_siswa_kelas['total_poin'] ?> Poin
                </div>
            <?php else: ?>
                <p class="text-muted mt-4">Belum ada data.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="leader-card h-100" style="border-color: #ffd700;">
            <div class="crown-icon"><i class="fas fa-crown fa-lg"></i></div>
            <h5 class="font-weight-bold text-gray-600 mb-4">Juara 1 Satu Sekolah</h5>
            
            <?php if ($top_siswa_sekolah): ?>
                <?php $foto = $top_siswa_sekolah['foto'] ? $top_siswa_sekolah['foto'] : 'default.png'; ?>
                <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="leader-avatar" alt="Top School" style="border-color: #ffd700;">
                <h4 class="font-weight-bold text-warning mb-1"><?= $top_siswa_sekolah['nama_lengkap'] ?></h4>
                <p class="text-muted mb-3"><?= $top_siswa_sekolah['nama_kelas'] ?></p>
                <div class="badge badge-warning text-white px-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(45deg, #FFD700, #FDB931); border: none; font-size: 1rem;">
                    <i class="fas fa-star mr-1"></i> <?= $top_siswa_sekolah['total_poin'] ?> Poin
                </div>
            <?php else: ?>
                <p class="text-muted mt-4">Belum ada data.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>