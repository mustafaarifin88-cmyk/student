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
    .form-control-modern {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #e3e6f0;
        background-color: #f8f9fc;
    }
    .form-control-modern:focus {
        background-color: #fff;
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
    }
    .preview-upload {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e3e6f0;
        margin-bottom: 10px;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Admin</h1>
    <button type="button" class="btn btn-gradient-primary btn-sm rounded-pill px-3" data-toggle="modal" data-target="#addModal">
        <i class="fas fa-plus mr-1"></i> Tambah Admin
    </button>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="45%">Info Admin</th>
                        <th width="30%">Username</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php $i = 1; foreach ($users as $row) : ?>
                            <tr>
                                <td class="text-center font-weight-bold text-gray-400"><?= $i++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php $foto = $row['foto'] ? $row['foto'] : 'default.png'; ?>
                                        <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="user-avatar mr-3" alt="Foto Profil">
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= $row['nama_lengkap'] ?></div>
                                            <div class="small text-muted text-uppercase" style="font-size: 0.7rem;">Administrator</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-gray-600 bg-light px-3 py-1 rounded-pill border">
                                        <i class="fas fa-user-shield mr-2 text-primary"></i> <?= $row['username'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="action-btn bg-light text-primary mr-1 border-0" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>" title="Edit">
                                        <i class="fas fa-pen fa-sm"></i>
                                    </button>
                                    
                                    <?php if(session()->get('id') != $row['id']): ?>
                                        <a href="<?= base_url('admin/user/delete/' . $row['id']) ?>" class="action-btn bg-light text-danger" onclick="return confirm('Yakin ingin menghapus admin ini?')" title="Hapus">
                                            <i class="fas fa-trash fa-sm"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="action-btn bg-light text-muted" title="Sedang Login" style="cursor: not-allowed;">
                                            <i class="fas fa-ban fa-sm"></i>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal-content-modern">
                                        <div class="modal-header modal-header-modern">
                                            <h5 class="modal-title font-weight-bold"><i class="fas fa-user-edit mr-2"></i> Edit Admin</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('admin/user/update/' . $row['id']) ?>" method="post" enctype="multipart/form-data">
                                            <div class="modal-body p-4">
                                                <div class="text-center mb-4">
                                                    <?php $fotoEdit = $row['foto'] ? $row['foto'] : 'default.png'; ?>
                                                    <img src="<?= base_url('uploads/profil/' . $fotoEdit) ?>" class="preview-upload" id="previewEdit<?= $row['id'] ?>">
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
                                                <button type="submit" class="btn btn-gradient-primary rounded-pill px-4">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="<?= base_url('assets/dist/img/empty.svg') ?>" alt="No Data" style="width: 150px; opacity: 0.5;" class="mb-3">
                                <p class="text-muted">Belum ada data admin.</p>
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
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i> Tambah Admin Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/user/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('assets/dist/img/default-150x150.png') ?>" class="preview-upload" id="previewAdd">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-gray-700 small">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control form-control-modern" placeholder="Masukkan nama lengkap" required>
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
                    <button type="submit" class="btn btn-gradient-primary rounded-pill px-4">Simpan Data</button>
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