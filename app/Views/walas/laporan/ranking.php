<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
    }
    .table-modern tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
        color: #5a5c69;
        font-size: 0.95rem;
    }
    .table-modern tbody tr:hover {
        background-color: #fcfcfd;
    }
    .btn-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(28, 200, 138, 0.4);
    }
    .btn-gradient-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(28, 200, 138, 0.6);
        color: white;
    }
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .rank-badge {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        margin: 0 auto;
    }
    .rank-1 { background-color: #FFD700; color: #fff; box-shadow: 0 4px 10px rgba(255, 215, 0, 0.4); font-size: 1.2rem; }
    .rank-2 { background-color: #C0C0C0; color: #fff; box-shadow: 0 4px 10px rgba(192, 192, 192, 0.4); font-size: 1.1rem; }
    .rank-3 { background-color: #CD7F32; color: #fff; box-shadow: 0 4px 10px rgba(205, 127, 50, 0.4); font-size: 1rem; }
    .rank-other { background-color: #f1f3f9; color: #858796; font-size: 0.9rem; }
    
    .tr-rank-1 { background-color: rgba(255, 215, 0, 0.05); }
    .tr-rank-2 { background-color: rgba(192, 192, 192, 0.05); }
    .tr-rank-3 { background-color: rgba(205, 127, 50, 0.05); }

    .points-display {
        font-weight: 800;
        color: #1cc88a;
        font-size: 1.1rem;
    }

    @media print {
        .no-print { display: none !important; }
        .card-modern { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Ranking Siswa</h1>
        <p class="mb-0 text-muted small">Peringkat berdasarkan total poin keaktifan siswa di kelas Anda.</p>
    </div>
    <button onclick="window.print()" class="btn btn-gradient-success btn-sm rounded-pill px-4 mt-3 mt-sm-0">
        <i class="fas fa-print mr-2"></i> Cetak Ranking
    </button>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">Peringkat</th>
                        <th width="60%">Identitas Siswa</th>
                        <th width="30%" class="text-center">Total Poin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ranking)) : ?>
                        <?php $i = 1; foreach ($ranking as $row) : ?>
                            <?php 
                                $rankClass = 'rank-other';
                                $trClass = '';
                                if ($i == 1) { $rankClass = 'rank-1'; $trClass = 'tr-rank-1'; }
                                elseif ($i == 2) { $rankClass = 'rank-2'; $trClass = 'tr-rank-2'; }
                                elseif ($i == 3) { $rankClass = 'rank-3'; $trClass = 'tr-rank-3'; }
                            ?>
                            <tr class="<?= $trClass ?>">
                                <td class="text-center">
                                    <div class="rank-badge <?= $rankClass ?>">
                                        <?php if ($i <= 3): ?>
                                            <i class="fas fa-trophy" style="font-size: 0.8em;"></i>
                                        <?php else: ?>
                                            <?= $i ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php $foto = $row['foto'] ? $row['foto'] : 'default.png'; ?>
                                        <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="avatar-circle mr-3" alt="Foto Siswa">
                                        <div>
                                            <div class="font-weight-bold text-dark" style="font-size: 1rem;"><?= $row['nama_lengkap'] ?></div>
                                            <small class="text-muted">NISN: <?= $row['nisn'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="points-display">
                                        <?= number_format($row['total_poin']) ?> <small class="text-muted font-weight-normal">pts</small>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++; endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-chart-bar fa-4x text-gray-200 mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data ranking untuk ditampilkan.</p>
                                    <small class="text-muted">Pastikan Anda memiliki siswa di kelas ini.</small>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>