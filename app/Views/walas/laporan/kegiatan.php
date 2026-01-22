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
        border-color: #1cc88a;
        box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.1);
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
        width: 40px;
        height: 40px;
        background-color: #e3e6f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4e73df;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .badge-poin {
        background-color: #e0f7fa;
        color: #006064;
        border: 1px solid #b2ebf2;
    }
    .thumbnail-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
        border: 2px solid #e3e6f0;
    }
    .thumbnail-img:hover {
        transform: scale(1.1);
    }
    @media print {
        .no-print { display: none !important; }
        .card-modern { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Laporan Kegiatan Kelas</h1>
    <button onclick="window.print()" class="btn btn-gradient-success btn-sm rounded-pill px-4">
        <i class="fas fa-print mr-2"></i> Cetak Laporan
    </button>
</div>

<div class="card card-modern mb-4 no-print">
    <div class="card-body p-4">
        <form action="" method="get">
            <div class="row align-items-end">
                <div class="col-md-8 mb-3 mb-md-0">
                    <label class="font-weight-bold text-uppercase filter-label">Rentang Waktu</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-group-text-modern">
                                <i class="fas fa-calendar-alt text-success"></i>
                            </span>
                        </div>
                        <select name="waktu" class="custom-select form-control-modern border-left-0" style="border-radius: 0 10px 10px 0;" onchange="this.form.submit()">
                            <option value="">Semua Data</option>
                            <option value="1_minggu" <?= ($selected_waktu == '1_minggu') ? 'selected' : '' ?>>1 Minggu Terakhir</option>
                            <option value="1_bulan" <?= ($selected_waktu == '1_bulan') ? 'selected' : '' ?>>1 Bulan Terakhir</option>
                            <option value="1_tahun" <?= ($selected_waktu == '1_tahun') ? 'selected' : '' ?>>1 Tahun Terakhir</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="<?= base_url('walas/laporan/kegiatan') ?>" class="btn btn-light btn-block rounded-pill font-weight-bold" style="height: 45px; line-height: 30px; border: 1px solid #e3e6f0;">
                        <i class="fas fa-sync-alt mr-1"></i> Reset Filter
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
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="25%">Siswa</th>
                        <th width="25%">Kegiatan</th>
                        <th width="15%" class="text-center">Bukti</th>
                        <th width="15%" class="text-center">Poin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)) : ?>
                        <?php $i = 1; foreach ($logs as $log) : ?>
                            <tr>
                                <td class="text-center font-weight-bold text-gray-400"><?= $i++ ?></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold text-dark">
                                            <?= date('d M Y', strtotime($log['tanggal_dikerjakan'])) ?>
                                        </span>
                                        <small class="text-muted">
                                            <i class="far fa-clock mr-1"></i>
                                            <?= date('H:i', strtotime($log['tanggal_dikerjakan'])) ?> WIB
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle mr-3 bg-light text-success">
                                            <?= substr($log['nama_siswa'], 0, 1) ?>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= $log['nama_siswa'] ?></div>
                                            <small class="text-muted">NISN: <?= $log['nisn'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="font-weight-bold text-success"><?= $log['judul'] ?></span>
                                        <small class="text-muted badge badge-light border mt-1" style="width: fit-content;">
                                            <?= isset($log['tipe']) ? ucfirst($log['tipe']) : 'Umum' ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if(!empty($log['bukti_foto'])): ?>
                                        <a href="<?= base_url('uploads/bukti/' . $log['bukti_foto']) ?>" target="_blank" title="Lihat Bukti Foto">
                                            <img src="<?= base_url('uploads/bukti/' . $log['bukti_foto']) ?>" class="thumbnail-img" alt="Bukti" onerror="this.src='<?= base_url('assets/dist/img/default-150x150.png') ?>'">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small font-italic">- Tidak ada -</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-poin px-3 py-2 rounded-pill font-weight-bold">
                                        + <?= $log['total_poin_diperoleh'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-clipboard-check fa-4x text-gray-200 mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada aktivitas siswa pada rentang waktu ini.</p>
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