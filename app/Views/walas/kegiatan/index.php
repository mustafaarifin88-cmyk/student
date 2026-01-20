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
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }
    .table-modern tbody tr {
        transition: all 0.2s;
    }
    .table-modern tbody tr:hover {
        background-color: #fcfcfd;
        transform: scale(1.005);
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
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
    .action-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        border: none;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .badge-date {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
        font-size: 0.8rem;
    }
    .activity-icon {
        width: 45px;
        height: 45px;
        background: #e0f2f1;
        color: #00897b;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Daftar Kegiatan</h1>
        <p class="mb-0 text-muted small">Kelola tugas dan aktivitas untuk siswa kelas Anda.</p>
    </div>
    <a href="<?= base_url('walas/kegiatan/create') ?>" class="btn btn-gradient-success btn-sm rounded-pill px-4 py-2 mt-3 mt-sm-0">
        <i class="fas fa-plus mr-2"></i> Tambah Kegiatan
    </a>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="30%">Nama Kegiatan</th>
                        <th width="35%">Instruksi Singkat</th>
                        <th width="20%">Tanggal Dibuat</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kegiatan)) : ?>
                        <?php $i = 1; foreach ($kegiatan as $row) : ?>
                            <tr>
                                <td class="text-center font-weight-bold text-gray-400"><?= $i++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon mr-3">
                                            <i class="fas fa-tasks"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= $row['judul'] ?></div>
                                            <div class="small text-muted">ID: #<?= $row['id'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?= (strlen($row['instruksi']) > 50) ? substr($row['instruksi'], 0, 50) . '...' : $row['instruksi'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-date px-3 py-2 rounded-pill">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <?= date('d M Y', strtotime($row['tanggal_dibuat'])) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('walas/kegiatan/edit/' . $row['id']) ?>" class="action-btn bg-light text-primary mr-1" title="Edit Kegiatan">
                                        <i class="fas fa-pen fa-sm"></i>
                                    </a>
                                    <a href="<?= base_url('walas/kegiatan/delete/' . $row['id']) ?>" class="action-btn bg-light text-danger" onclick="return confirm('Yakin ingin menghapus kegiatan ini? Semua log aktivitas siswa terkait akan ikut terhapus.')" title="Hapus Kegiatan">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <img src="<?= base_url('assets/dist/img/empty.svg') ?>" alt="No Data" style="width: 150px; opacity: 0.5;" class="mb-3">
                                    <h5 class="text-muted font-weight-bold">Belum ada kegiatan</h5>
                                    <p class="text-muted small mb-0">Silakan tambahkan kegiatan baru untuk siswa Anda.</p>
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