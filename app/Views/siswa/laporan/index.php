<?= $this->extend('layouts/siswa_main') ?>

<?= $this->section('content') ?>
<style>
    .report-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        box-shadow: 0 10px 25px rgba(118, 75, 162, 0.3);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .report-circle-bg {
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        z-index: 0;
    }
    .btn-export {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-pdf {
        background: #ff7675;
        color: white;
        box-shadow: 0 4px 15px rgba(255, 118, 117, 0.4);
    }
    .btn-pdf:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 118, 117, 0.6);
        color: white;
    }
    .btn-excel {
        background: #00b894;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 184, 148, 0.4);
    }
    .btn-excel:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 184, 148, 0.6);
        color: white;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #e9ecef;
        border-radius: 2px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        animation: fadeInUp 0.5s ease-out both;
    }
    .timeline-dot {
        position: absolute;
        left: -34px;
        top: 15px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #6c5ce7;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
    }
    .timeline-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border-left: 5px solid #6c5ce7;
        transition: transform 0.2s;
    }
    .timeline-card:hover {
        transform: translateX(5px);
    }
    .timeline-date {
        font-size: 0.85rem;
        color: #a4b0be;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    .points-badge {
        background: rgba(108, 92, 231, 0.1);
        color: #6c5ce7;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 20px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .custom-select-modern {
        border-radius: 50px;
        border: 2px solid #e0e0e0;
        padding: 0.5rem 2rem 0.5rem 1rem;
        font-weight: 600;
        color: #666;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .custom-select-modern:focus {
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }
</style>

<div class="row animate-pop">
    <div class="col-12">
        <div class="report-header-card d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="report-circle-bg" style="top: -50px; right: -50px;"></div>
            <div class="report-circle-bg" style="bottom: -80px; left: 30px;"></div>
            
            <div class="position-relative z-index-1 text-center text-md-left mb-3 mb-md-0">
                <h2 class="font-weight-bold mb-1">Laporan Aktivitas</h2>
                <p class="mb-0" style="opacity: 0.9;">Rekap jejak keaktifanmu selama ini.</p>
                <div class="mt-3">
                    <div class="badge badge-light text-primary px-3 py-2 rounded-pill shadow-sm mr-2">
                        <i class="fas fa-star mr-1"></i> Total Poin: <?= number_format($siswa['total_poin']) ?>
                    </div>
                    <div class="badge badge-light text-success px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-check-circle mr-1"></i> Selesai: <?= count($logs) ?> Tugas
                    </div>
                </div>
            </div>
            
            <?php 
                // Buat query string untuk tombol export agar mengikuti filter
                $queryString = isset($selected_waktu) && $selected_waktu ? '?waktu=' . $selected_waktu : ''; 
            ?>
            <div class="position-relative z-index-1 d-flex flex-column flex-sm-row">
                <a href="<?= base_url('siswa/laporan/cetak_pdf') . $queryString ?>" target="_blank" class="btn btn-pdf btn-export mb-2 mb-sm-0 mr-sm-3">
                    <i class="fas fa-file-pdf mr-2"></i> Download PDF
                </a>
                <a href="<?= base_url('siswa/laporan/cetak_excel') . $queryString ?>" target="_blank" class="btn btn-excel btn-export">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4 animate-pop">
    <div class="col-md-6 d-flex align-items-center">
        <h5 class="font-weight-bold text-gray-700 m-0 pl-2 border-left-4 border-primary">
            <span class="ml-2">Timeline Aktivitas</span>
        </h5>
    </div>
    <div class="col-md-6 text-md-right mt-3 mt-md-0">
        <form action="" method="get" class="form-inline justify-content-md-end justify-content-center">
            <label class="mr-2 font-weight-bold text-muted small">Filter Waktu:</label>
            <select name="waktu" class="custom-select custom-select-modern" onchange="this.form.submit()">
                <option value="">Semua Waktu</option>
                <option value="1_minggu" <?= (isset($selected_waktu) && $selected_waktu == '1_minggu') ? 'selected' : '' ?>>1 Minggu Terakhir</option>
                <option value="1_bulan" <?= (isset($selected_waktu) && $selected_waktu == '1_bulan') ? 'selected' : '' ?>>1 Bulan Terakhir</option>
                <option value="1_tahun" <?= (isset($selected_waktu) && $selected_waktu == '1_tahun') ? 'selected' : '' ?>>1 Tahun Terakhir</option>
            </select>
        </form>
    </div>
</div>

<?php if (empty($logs)): ?>
    <div class="row justify-content-center animate-pop">
        <div class="col-md-8">
            <div class="empty-state">
                <img src="<?= base_url('assets/dist/img/empty.svg') ?>" class="img-fluid mb-4" style="max-width: 200px; opacity: 0.7;" alt="Kosong">
                <h4 class="font-weight-bold text-gray-700">Belum Ada Riwayat</h4>
                <p class="text-muted">
                    <?php if(isset($selected_waktu) && $selected_waktu): ?>
                        Tidak ada aktivitas pada rentang waktu yang dipilih. Coba reset filter.
                    <?php else: ?>
                        Kamu belum menyelesaikan tugas apapun. Yuk mulai kerjakan tugasmu!
                    <?php endif; ?>
                </p>
                <a href="<?= base_url('siswa/tugas') ?>" class="btn btn-primary rounded-pill px-4 mt-2">Lihat Tugas</a>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="timeline">
                <?php foreach ($logs as $index => $log): ?>
                    <div class="timeline-item" style="animation-delay: <?= $index * 0.1 ?>s">
                        <div class="timeline-dot"></div>
                        <div class="timeline-card">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="timeline-date">
                                    <i class="far fa-clock mr-1"></i> 
                                    <?= date('d M Y, H:i', strtotime($log['tanggal_dikerjakan'])) ?> WIB
                                </span>
                                <span class="points-badge">+<?= $log['total_poin_diperoleh'] ?> Poin</span>
                            </div>
                            <h5 class="font-weight-bold text-dark mb-1"><?= $log['judul'] ?></h5>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-check-double text-success mr-1"></i> Tugas telah diselesaikan dan tercatat di sistem.
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-5 mb-5">
                <p class="text-muted small">
                    <i class="fas fa-flag-checkered mr-1"></i> Akhir dari riwayat aktivitasmu.
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>