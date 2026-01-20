<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .filter-label {
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #858796;
        margin-bottom: 8px;
    }
    .form-control-modern {
        border-radius: 10px;
        height: 45px;
        border: 1px solid #e3e6f0;
        background-color: #f8f9fc;
        font-size: 0.9rem;
    }
    .form-control-modern:focus {
        background-color: #fff;
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
    }
    .input-group-text-modern {
        background-color: #fff;
        border: 1px solid #e3e6f0;
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: #b7b9cc;
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
    .btn-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .btn-gradient-primary:hover {
        transform: translateY(-2px);
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
    
    .medal-icon { margin-right: 5px; }
    
    .tr-rank-1 { background-color: rgba(255, 215, 0, 0.05); }
    .tr-rank-2 { background-color: rgba(192, 192, 192, 0.05); }
    .tr-rank-3 { background-color: rgba(205, 127, 50, 0.05); }

    .points-display {
        font-weight: 800;
        color: #4e73df;
        font-size: 1.1rem;
    }

    @media print {
        .no-print { display: none !important; }
        .card-modern { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Ranking Siswa</h1>
    <button onclick="window.print()" class="btn btn-gradient-primary btn-sm rounded-pill px-4">
        <i class="fas fa-print mr-2"></i> Cetak Ranking
    </button>
</div>

<div class="card card-modern mb-4 no-print">
    <div class="card-body p-4">
        <form action="" method="get">
            <div class="row align-items-end">
                <div class="col-md-10 mb-3 mb-md-0">
                    <label class="font-weight-bold text-uppercase filter-label">Filter Berdasarkan Kelas</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-group-text-modern">
                                <i class="fas fa-filter text-primary"></i>
                            </span>
                        </div>
                        <select name="kelas" class="custom-select form-control-modern border-left-0" style="border-radius: 0 10px 10px 0;" onchange="this.form.submit()">
                            <option value="">-- Tampilkan Semua Kelas --</option>
                            <?php foreach ($kelas as $k) : ?>
                                <option value="<?= $k['id'] ?>" <?= ($selected_kelas == $k['id']) ? 'selected' : '' ?>>
                                    <?= $k['nama_kelas'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="<?= base_url('admin/laporan/ranking') ?>" class="btn btn-light btn-block rounded-pill font-weight-bold" style="height: 45px; line-height: 30px; border: 1px solid #e3e6f0;">
                        <i class="fas fa-sync-alt mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">Peringkat</th>
                        <th width="45%">Identitas Siswa</th>
                        <th width="25%">Kelas</th>
                        <th width="20%" class="text-center">Total Poin</th>
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
                                <td>
                                    <span class="badge badge-light px-3 py-2 rounded-pill border">
                                        <?= $row['nama_kelas'] ?? '-' ?>
                                    </span>
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
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-medal fa-4x text-gray-200 mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data ranking untuk ditampilkan.</p>
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