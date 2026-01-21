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
    .btn-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4);
    }
    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(78, 115, 223, 0.6);
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
        border: none;
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
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }
    .modal-header-modern-import {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }
    .form-control-modern {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #e3e6f0;
        background-color: #f8f9fc;
    }
    .form-control-modern:focus {
        background-color: #fff;
        border-color: #1cc88a;
        box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.1);
    }
    .preview-upload {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e3e6f0;
        margin-bottom: 10px;
    }
    .badge-poin {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Data Siswa</h1>
        <p class="mb-0 text-muted small">Kelola data siswa di kelas Anda.</p>
    </div>
    <div>
        <button type="button" class="btn btn-gradient-primary btn-sm rounded-pill px-3 mt-3 mt-sm-0 mr-2" data-toggle="modal" data-target="#importModal">
            <i class="fas fa-file-excel mr-1"></i> Import Excel
        </button>
        <button type="button" class="btn btn-gradient-success btn-sm rounded-pill px-3 mt-3 mt-sm-0" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-plus mr-1"></i> Tambah Siswa
        </button>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-warning border-0 shadow-sm rounded-lg mb-4">
        <i class="fas fa-exclamation-triangle mr-2"></i> <?= $error ?>
    </div>
<?php endif; ?>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="40%">Info Siswa</th>
                        <th width="25%">Akun Login</th>
                        <th width="15%" class="text-center">Poin</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($siswa)) : ?>
                        <?php $i = 1; foreach ($siswa as $row) : ?>
                            <tr>
                                <td class="text-center font-weight-bold text-gray-400"><?= $i++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php $foto = $row['foto'] ? $row['foto'] : 'default.png'; ?>
                                        <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="user-avatar mr-3" alt="Foto Siswa">
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= $row['nama_lengkap'] ?></div>
                                            <div class="small text-muted">NISN: <?= $row['nisn'] ? $row['nisn'] : '-' ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-gray-600 bg-light px-3 py-1 rounded-pill border small">
                                        <i class="fas fa-user-circle mr-1 text-muted"></i> <?= $row['username'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-poin px-3 py-2 rounded-pill font-weight-bold">
                                        <i class="fas fa-star text-warning mr-1"></i> <?= $row['total_poin'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="action-btn bg-light text-primary mr-1" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>" title="Edit">
                                        <i class="fas fa-pen fa-sm"></i>
                                    </button>
                                    <a href="<?= base_url('walas/siswa/delete/' . $row['id']) ?>" class="action-btn bg-light text-danger" onclick="return confirm('Yakin ingin menghapus siswa ini dari kelas?')" title="Hapus">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal-content-modern">
                                        <div class="modal-header modal-header-modern">
                                            <h5 class="modal-title font-weight-bold"><i class="fas fa-user-edit mr-2"></i> Edit Data Siswa</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('walas/siswa/update/' . $row['id']) ?>" method="post" enctype="multipart/form-data">
                                            <div class="modal-body p-4">
                                                <div class="text-center mb-4">
                                                    <?php $fotoEdit = $row['foto'] ? $row['foto'] : 'default.png'; ?>
                                                    <img src="<?= base_url('uploads/profil/' . $fotoEdit) ?>" class="preview-upload" id="previewEdit<?= $row['id'] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold text-gray-700 small">NISN</label>
                                                    <input type="text" name="nisn" class="form-control form-control-modern" value="<?= $row['nisn'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-gray-700 small">Nama Lengkap</label>
                                                    <input type="text" name="nama_lengkap" class="form-control form-control-modern" value="<?= $row['nama_lengkap'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-gray-700 small">Username</label>
                                                    <input type="text" name="username" class="form-control form-control-modern" value="<?= $row['username'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-gray-700 small">Password Baru <span class="text-muted font-weight-normal">(Opsional)</span></label>
                                                    <input type="password" name="password" class="form-control form-control-modern" placeholder="Kosongkan jika tidak diganti">
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-gray-700 small">Foto Profil</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="foto" accept="image/*" onchange="previewImage(this, 'previewEdit<?= $row['id'] ?>')">
                                                        <label class="custom-file-label" style="border-radius: 10px;">Pilih file...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-gradient-success rounded-pill px-4">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="<?= base_url('assets/dist/img/empty.svg') ?>" alt="No Data" style="width: 150px; opacity: 0.5;" class="mb-3">
                                <p class="text-muted">Belum ada siswa di kelas Anda.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i> Tambah Siswa Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('walas/siswa/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('assets/dist/img/default-150x150.png') ?>" class="preview-upload" id="previewAdd">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700 small">NISN</label>
                        <input type="text" name="nisn" class="form-control form-control-modern" placeholder="Nomor Induk Siswa Nasional">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700 small">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control form-control-modern" placeholder="Nama lengkap siswa" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700 small">Username</label>
                        <input type="text" name="username" class="form-control form-control-modern" placeholder="Username login" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700 small">Password</label>
                        <input type="password" name="password" class="form-control form-control-modern" placeholder="Password login" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700 small">Foto Profil</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="foto" accept="image/*" onchange="previewImage(this, 'previewAdd')">
                            <label class="custom-file-label" style="border-radius: 10px;">Pilih file...</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-success rounded-pill px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern-import">
                <h5 class="modal-title font-weight-bold" id="importModalLabel">
                    <i class="fas fa-file-import mr-2"></i> Import Data Siswa
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('walas/siswa/import') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-file-excel fa-4x text-success"></i>
                        </div>
                        <p class="text-muted">Upload file Excel (.xlsx) untuk menambahkan data siswa secara massal ke kelas Anda.</p>
                        <a href="<?= base_url('walas/siswa/template') ?>" class="btn btn-outline-success btn-sm rounded-pill mt-2">
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

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
            
            var fileName = input.files[0].name;
            var label = input.nextElementSibling;
            label.innerText = fileName;
        }
    }
</script>
<?= $this->endSection() ?>