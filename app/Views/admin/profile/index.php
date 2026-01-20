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
        padding: 2rem;
        border: none;
        text-align: center;
        color: white;
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
    .profile-img-container {
        position: relative;
        width: 140px;
        height: 140px;
        margin: -70px auto 20px;
    }
    .profile-img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        background-color: #fff;
    }
    .camera-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 40px;
        height: 40px;
        background: #1cc88a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        border: 3px solid #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .camera-btn:hover {
        transform: scale(1.1);
    }
    .hidden-file-input {
        display: none;
    }
</style>

<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="card card-modern mt-5">
            <div class="card-header-gradient">
                <h4 class="font-weight-bold mb-0">Edit Profil</h4>
                <p class="mb-5 text-white-50">Perbarui informasi akun Anda</p>
            </div>
            
            <div class="card-body p-4 p-md-5 pt-0">
                <form action="<?= base_url('admin/profile/update') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="profile-img-container">
                        <?php 
                            $foto = $user['foto'] ? $user['foto'] : 'default.png';
                            $fotoUrl = base_url('uploads/profil/' . $foto);
                        ?>
                        <img src="<?= $fotoUrl ?>" id="profilePreview" class="profile-img" alt="Foto Profil">
                        <label for="fotoInput" class="camera-btn" title="Ganti Foto">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="fotoInput" name="foto" class="hidden-file-input" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <div class="text-center mb-4">
                        <h5 class="font-weight-bold text-gray-800"><?= $user['nama_lengkap'] ?></h5>
                        <span class="badge badge-primary px-3 py-1 rounded-pill">Administrator</span>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-gray-600 text-uppercase">Nama Lengkap</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-text-modern">
                                    <i class="fas fa-user text-gray-400"></i>
                                </span>
                            </div>
                            <input type="text" name="nama_lengkap" class="form-control form-control-modern with-icon" value="<?= $user['nama_lengkap'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-gray-600 text-uppercase">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-text-modern">
                                    <i class="fas fa-at text-gray-400"></i>
                                </span>
                            </div>
                            <input type="text" name="username" class="form-control form-control-modern with-icon" value="<?= $user['username'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-gray-600 text-uppercase">
                            Password Baru <span class="text-muted font-weight-normal ml-1">(Opsional)</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-text-modern">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </span>
                            </div>
                            <input type="password" name="password" class="form-control form-control-modern with-icon" placeholder="Kosongkan jika tidak ingin mengganti password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradient btn-block mt-5">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
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
                document.getElementById('profilePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>