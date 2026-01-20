<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .card-header-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        padding: 1.5rem;
        border: none;
    }
    .form-control-modern {
        border-radius: 10px;
        height: auto;
        padding: 12px 15px;
        border: 1px solid #e3e6f0;
        background-color: #f8f9fc;
        font-size: 0.95rem;
        transition: all 0.3s;
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
    .form-control-modern.with-icon {
        border-left: none;
        border-radius: 0 10px 10px 0;
    }
    .btn-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        color: white;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        transition: transform 0.2s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        color: white;
    }
    .btn-light-modern {
        background: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 50px;
        padding: 12px 25px;
        font-weight: 600;
        color: #858796;
    }
    .btn-light-modern:hover {
        background: #eaecf4;
        color: #5a5c69;
    }
    .profile-upload {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 2rem;
    }
    .profile-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        background-color: #e3e6f0;
    }
    .upload-btn-wrapper {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #4e73df;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .upload-btn-wrapper:hover {
        transform: scale(1.1);
        background: #224abe;
    }
    .upload-btn-wrapper input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .custom-select-modern {
        border-radius: 10px;
        height: 48px;
        border: 1px solid #e3e6f0;
        background-color: #f8f9fc;
    }
</style>

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card card-modern">
            <div class="card-header card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-white">
                    <i class="fas <?= isset($siswa) ? 'fa-user-edit' : 'fa-user-plus' ?> mr-2"></i> 
                    <?= $title ?>
                </h5>
                <a href="<?= base_url('admin/siswa') ?>" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm text-primary font-weight-bold">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <?php $action = isset($siswa) ? 'update/' . $siswa['id'] : 'store'; ?>
                <form action="<?= base_url('admin/siswa/' . $action) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="profile-upload">
                                <?php 
                                    $foto = isset($siswa['foto']) ? $siswa['foto'] : 'default.png';
                                    $fotoUrl = base_url('uploads/profil/' . $foto);
                                ?>
                                <img src="<?= $fotoUrl ?>" alt="Preview Foto" class="profile-preview" id="imgPreview">
                                <div class="upload-btn-wrapper" title="Ganti Foto">
                                    <i class="fas fa-camera text-white"></i>
                                    <input type="file" name="foto" accept="image/*" onchange="previewImage(this)">
                                </div>
                            </div>
                            <p class="text-muted small mb-4">Klik ikon kamera untuk mengganti foto (Max 2MB)</p>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-gray-600 text-uppercase">NISN</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-modern">
                                            <i class="fas fa-id-card text-gray-400"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="nisn" class="form-control form-control-modern with-icon" placeholder="Nomor Induk Siswa Nasional" value="<?= isset($siswa) ? $siswa['nisn'] : old('nisn') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-gray-600 text-uppercase">Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-modern">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="nama_lengkap" class="form-control form-control-modern with-icon" placeholder="Nama lengkap siswa" value="<?= isset($siswa) ? $siswa['nama_lengkap'] : old('nama_lengkap') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-gray-600 text-uppercase">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-modern">
                                            <i class="fas fa-at text-gray-400"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="username" class="form-control form-control-modern with-icon" placeholder="Username untuk login" value="<?= isset($siswa) ? $siswa['username'] : old('username') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-gray-600 text-uppercase">
                                    Password <?= isset($siswa) ? '<span class="text-danger font-weight-normal text-xs ml-1">*Kosongkan jika tidak diganti</span>' : '' ?>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-modern">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" class="form-control form-control-modern with-icon" placeholder="*******" <?= isset($siswa) ? '' : 'required' ?>>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-gray-600 text-uppercase">Kelas</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-modern">
                                            <i class="fas fa-layer-group text-gray-400"></i>
                                        </span>
                                    </div>
                                    <select name="kelas_id" class="custom-select custom-select-modern" style="border-left: none; border-radius: 0 10px 10px 0;" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php foreach ($kelas as $k): ?>
                                            <?php 
                                            $selected = '';
                                            if (isset($siswa) && $siswa['kelas_id'] == $k['id']) {
                                                $selected = 'selected';
                                            }
                                            ?>
                                            <option value="<?= $k['id'] ?>" <?= $selected ?>>
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="<?= base_url('admin/siswa') ?>" class="btn btn-light-modern mr-3">Batal</a>
                        <button type="submit" class="btn btn-gradient px-5">
                            <i class="fas fa-save mr-2"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>