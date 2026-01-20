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
    .btn-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
        color: white;
    }
    .btn-gradient-success {
        background: linear-gradient(135deg, #2af598 0%, #009efd 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(42, 245, 152, 0.4);
    }
    .btn-gradient-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(42, 245, 152, 0.6);
        color: white;
    }
    .avatar-circle {
        width: 35px;
        height: 35px;
        background-color: #e3e6f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4e73df;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .modal-content-modern {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }
    .modal-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Kelas</h1>
    <div>
        <button type="button" class="btn btn-gradient-success btn-sm rounded-pill px-3 mr-2" data-toggle="modal" data-target="#importModal">
            <i class="fas fa-file-excel mr-1"></i> Import Excel
        </button>
        <a href="<?= base_url('admin/kelas/create') ?>" class="btn btn-gradient-primary btn-sm rounded-pill px-3">
            <i class="fas fa-plus mr-1"></i> Tambah Kelas
        </a>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="30%">Nama Kelas</th>
                        <th width="40%">Wali Kelas</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kelas)) : ?>
                        <?php $i = 1; foreach ($kelas as $row) : ?>
                            <tr>
                                <td class="text-center font-weight-bold text-gray-400"><?= $i++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle mr-3 bg-light text-primary">
                                            <i class="fas fa-layer-group"></i>
                                        </div>
                                        <span class="font-weight-bold"><?= $row['nama_kelas'] ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($row['nama_walas']): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle mr-2 bg-primary text-white" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                <?= substr($row['nama_walas'], 0, 1) ?>
                                            </div>
                                            <?= $row['nama_walas'] ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted font-italic pl-2">- Belum ditentukan -</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['nama_walas']): ?>
                                        <span class="badge badge-success px-3 py-2 rounded-pill">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning px-3 py-2 rounded-pill text-white">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/kelas/edit/' . $row['id']) ?>" class="action-btn bg-light text-primary mr-1" title="Edit">
                                        <i class="fas fa-pen fa-sm"></i>
                                    </a>
                                    <a href="<?= base_url('admin/kelas/delete/' . $row['id']) ?>" class="action-btn bg-light text-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="<?= base_url('assets/dist/img/empty.svg') ?>" alt="No Data" style="width: 150px; opacity: 0.5;" class="mb-3">
                                <p class="text-muted">Belum ada data kelas.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern">
                <h5 class="modal-title font-weight-bold" id="importModalLabel">
                    <i class="fas fa-file-import mr-2"></i> Import Data Kelas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kelas/import') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-file-excel fa-4x text-success"></i>
                        </div>
                        <p class="text-muted">Upload file Excel (.xlsx) sesuai format template untuk menambahkan data kelas secara massal.</p>
                        <a href="<?= base_url('admin/kelas/template') ?>" class="btn btn-outline-success btn-sm rounded-pill mt-2">
                            <i class="fas fa-download mr-1"></i> Download Template
                        </a>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700">Pilih File Excel</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_excel" name="file_excel" accept=".xlsx, .xls" required>
                            <label class="custom-file-label" style="border-radius: 10px;">Choose file...</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary rounded-pill px-4">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>