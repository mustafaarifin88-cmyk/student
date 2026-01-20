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
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
    .badge-soft-info {
        background-color: rgba(54, 185, 204, 0.1);
        color: #36b9cc;
        border: 1px solid rgba(54, 185, 204, 0.2);
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Data Guru</h1>
    <div>
        <button type="button" class="btn btn-gradient-success btn-sm rounded-pill px-3 mr-2" data-toggle="modal" data-target="#importModal">
            <i class="fas fa-file-excel mr-1"></i> Import Excel
        </button>
        <a href="<?= base_url('admin/guru/create') ?>" class="btn btn-gradient-primary btn-sm rounded-pill px-3">
            <i class="fas fa-plus mr-1"></i> Tambah Guru
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
                        <th width="35%">Info Guru</th>
                        <th width="20%">Username</th>
                        <th width="20%">Tugas Tambahan</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($guru)) : ?>
                        <?php $i = 1; foreach ($guru as $row) : ?>
                            <tr>
                                <td class="text-center font-weight-bold text-gray-400"><?= $i++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php $foto = $row['foto'] ? $row['foto'] : 'default.png'; ?>
                                        <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="user-avatar mr-3" alt="Foto Guru">
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= $row['nama_lengkap'] ?></div>
                                            <div class="small text-muted">NIP: <?= $row['nip'] ? $row['nip'] : '-' ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-gray-600"><i class="fas fa-user-circle mr-1 text-gray-400"></i> <?= $row['username'] ?></span>
                                </td>
                                <td>
                                    <?php 
                                    // Query manual sederhana untuk cek wali kelas, idealnya dipassing dari controller
                                    $db = \Config\Database::connect();
                                    $kelas = $db->table('kelas')->where('wali_kelas_id', $row['id'])->get()->getRowArray();
                                    ?>
                                    
                                    <?php if ($kelas): ?>
                                        <span class="badge badge-soft-info px-3 py-2 rounded-pill">
                                            <i class="fas fa-chalkboard-teacher mr-1"></i> Wali Kelas <?= $kelas['nama_kelas'] ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small font-italic">- Guru Mapel -</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success px-3 py-2 rounded-pill">Aktif</span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/guru/edit/' . $row['id']) ?>" class="action-btn bg-light text-primary mr-1" title="Edit">
                                        <i class="fas fa-pen fa-sm"></i>
                                    </a>
                                    <a href="<?= base_url('admin/guru/delete/' . $row['id']) ?>" class="action-btn bg-light text-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="<?= base_url('assets/dist/img/empty.svg') ?>" alt="No Data" style="width: 150px; opacity: 0.5;" class="mb-3">
                                <p class="text-muted">Belum ada data guru.</p>
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
                    <i class="fas fa-file-import mr-2"></i> Import Data Guru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/guru/import') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-file-excel fa-4x text-success"></i>
                        </div>
                        <p class="text-muted">Upload file Excel (.xlsx) sesuai format template untuk menambahkan data guru secara massal.</p>
                        <a href="<?= base_url('admin/guru/template') ?>" class="btn btn-outline-success btn-sm rounded-pill mt-2">
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