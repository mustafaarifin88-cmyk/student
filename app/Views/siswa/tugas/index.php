<?= $this->extend('layouts/siswa_main') ?>

<?= $this->section('content') ?>
<style>
    .task-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 2rem;
        overflow: hidden;
        background-color: #fff;
    }
    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .task-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 20px 20px 0 0;
    }
    .task-header.completed {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .task-body {
        padding: 2rem;
        background: white;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .custom-checkbox-modern .custom-control-label::before {
        border-radius: 5px;
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #ddd;
    }
    .custom-checkbox-modern .custom-control-label::after {
        width: 1.25rem;
        height: 1.25rem;
    }
    .custom-checkbox-modern .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #2575fc;
        border-color: #2575fc;
    }
    .custom-checkbox-modern .custom-control-label {
        padding-left: 0.5rem;
        padding-top: 0.15rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #555;
    }
    .criteria-item {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 10px;
        border: 1px solid #edf2f7;
        transition: all 0.2s;
    }
    .criteria-item:hover {
        background: #fff;
        border-color: #cbd5e0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .badge-poin {
        font-size: 0.85rem;
        padding: 0.4em 0.8em;
        border-radius: 50px;
        background-color: rgba(37, 117, 252, 0.1);
        color: #2575fc;
        font-weight: 700;
    }
    .btn-submit-task {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(37, 117, 252, 0.3);
        transition: all 0.2s;
    }
    .btn-submit-task:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 117, 252, 0.4);
    }
    .status-badge {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(5px);
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        border: 1px solid rgba(255,255,255,0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .completed-box {
        background-color: #f0fff4; 
        border: 2px dashed #38ef7d;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        margin-top: auto;
    }
</style>

<div class="row mb-4 animate-pop">
    <div class="col-12">
        <h2 class="font-weight-bold text-gray-800" style="font-family: 'Fredoka', sans-serif;">Daftar Tugas</h2>
        <p class="text-muted">Selesaikan tugas berikut untuk menambah poin keaktifanmu!</p>
    </div>
</div>

<?php if (empty($tugas)): ?>
    <div class="row justify-content-center animate-pop">
        <div class="col-md-6 text-center py-5">
            <img src="<?= base_url('assets/dist/img/empty.svg') ?>" class="img-fluid mb-4" style="max-width: 250px; opacity: 0.8;" alt="No Tasks">
            <h3 class="text-dark font-weight-bold mb-2">Hore! Tidak ada tugas.</h3>
            <p class="text-muted">Kamu sudah menyelesaikan semua tugas atau belum ada tugas baru dari Wali Kelas.</p>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($tugas as $t): ?>
            <div class="col-lg-6 mb-4">
                <div class="card task-card h-100">
                    <div class="task-header <?= $t['status'] ? 'completed' : '' ?> position-relative">
                        <div class="status-badge">
                            <?php if($t['status']): ?>
                                <i class="fas fa-check-circle mr-1"></i> Selesai
                            <?php else: ?>
                                <i class="fas fa-hourglass-half mr-1"></i> Pending
                            <?php endif; ?>
                        </div>
                        <h5 class="font-weight-bold mb-1 pr-5" style="font-size: 1.25rem;"><?= $t['kegiatan']['judul'] ?></h5>
                        <small class="text-white-50"><i class="far fa-calendar-alt mr-1"></i> Dibuat: <?= date('d M Y', strtotime($t['kegiatan']['tanggal_dibuat'])) ?></small>
                    </div>
                    
                    <div class="task-body">
                        <div class="mb-4">
                            <h6 class="font-weight-bold text-primary text-uppercase small mb-2" style="letter-spacing: 1px;">Instruksi</h6>
                            <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.6;">
                                <?= nl2br($t['kegiatan']['instruksi']) ?>
                            </p>
                        </div>

                        <?php if($t['status']): ?>
                            <div class="completed-box">
                                <i class="fas fa-medal fa-3x text-success mb-3"></i>
                                <h2 class="text-success font-weight-bold mb-1">+<?= $t['nilai'] ?> Poin</h2>
                                <p class="small text-muted mb-0">Kamu hebat! Tugas ini sudah diverifikasi selesai.</p>
                            </div>
                        <?php else: ?>
                            <form action="<?= base_url('siswa/tugas/submit') ?>" method="post" class="mt-auto">
                                <?= csrf_field() ?>
                                <input type="hidden" name="kegiatan_id" value="<?= $t['kegiatan']['id'] ?>">
                                
                                <h6 class="font-weight-bold text-primary text-uppercase small mb-3" style="letter-spacing: 1px;">Checklist Poin</h6>
                                
                                <?php if(!empty($t['kriteria'])): ?>
                                    <div class="mb-4">
                                        <?php foreach ($t['kriteria'] as $k): ?>
                                            <div class="criteria-item d-flex align-items-center justify-content-between">
                                                <div class="custom-control custom-checkbox custom-checkbox-modern flex-grow-1">
                                                    <input type="checkbox" class="custom-control-input" id="kriteria_<?= $k['id'] ?>" name="kriteria[]" value="<?= $k['id'] ?>">
                                                    <label class="custom-control-label" for="kriteria_<?= $k['id'] ?>">
                                                        <?= $k['deskripsi'] ?>
                                                    </label>
                                                </div>
                                                <span class="badge-poin ml-2">+<?= $k['poin'] ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info small border-0 bg-soft-info text-info mb-4">
                                        <i class="fas fa-info-circle mr-1"></i> Tidak ada kriteria khusus. Klik tombol di bawah untuk konfirmasi.
                                    </div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-submit-task btn-block text-white" onclick="return confirm('Apakah kamu yakin sudah mengerjakan tugas ini sesuai kriteria yang dipilih? Data tidak bisa diubah setelah dikirim.')">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan Saya
                                    </span>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>