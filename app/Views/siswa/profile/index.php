<?= $this->extend('layouts/siswa_main') ?>

<?= $this->section('content') ?>
<style>
    .profile-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        position: relative;
    }
    .profile-header-bg {
        height: 150px;
        background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
    }
    .profile-img-wrapper {
        width: 140px;
        height: 140px;
        margin: -70px auto 10px;
        position: relative;
    }
    .profile-img-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        background-color: #fff;
    }
    .camera-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 40px;
        height: 40px;
        background: #2575fc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        border: 3px solid white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .camera-btn:hover {
        transform: scale(1.1);
    }
    .form-control-modern {
        border-radius: 50px;
        padding: 1.2rem 1.5rem;
        border: 2px solid #f0f0f0;
        background-color: #f8f9fa;
        font-size: 0.95rem;
        height: auto;
        transition: all 0.3s;
    }
    .form-control-modern:focus {
        background-color: #fff;
        border-color: #a18cd1;
        box-shadow: 0 0 0 4px rgba(161, 140, 209, 0.1);
    }
    .form-control-modern[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
    .btn-save-profile {
        background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
        border: none;
        border-radius: 50px;
        padding: 12px 40px;
        font-weight: 700;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(37, 117, 252, 0.3);
        transition: all 0.3s;
        color: white;
    }
    .btn-save-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 117, 252, 0.4);
    }
</style>

<div class="row justify-content-center animate-pop">
    <div class="col-md-8 col-lg-6">
        <div class="profile-card mb-5">
            <div class="profile-header-bg"></div>
            
            <div class="px-4 pb-5">
                <form action="<?= base_url('siswa/profile/update') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="text-center">
                        <div class="profile-img-wrapper">
                            <?php 
                                $foto = $user['foto'] ? $user['foto'] : 'default.png';
                                $fotoUrl = base_url('uploads/profil/' . $foto);
                            ?>
                            <img src="<?= $fotoUrl ?>" id="profilePreview" class="profile-img-preview" alt="Foto Profil">
                            <label for="fotoInput" class="camera-btn" title="Ganti Foto">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="fotoInput" name="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                        </div>
                        
                        <h4 class="font-weight-bold text-dark mt-3"><?= $user['nama_lengkap'] ?></h4>
                        <span class="badge badge-pill badge-primary px-3 py-1">Siswa</span>
                    </div>

                    <div class="mt-5">
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-muted small ml-3 mb-2">USERNAME (Tidak dapat diubah)</label>
                            <input type="text" class="form-control form-control-modern" value="<?= $user['username'] ?>" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-muted small ml-3 mb-2">GANTI PASSWORD BARU</label>
                            <input type="password" name="password" class="form-control form-control-modern" placeholder="Kosongkan jika tidak ingin mengganti password">
                            <small class="text-muted ml-3 mt-1 d-block"><i class="fas fa-info-circle mr-1"></i> Minimal 6 karakter.</small>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-save-profile btn-block">
                                <i class="fas fa-save mr-2"></i> SIMPAN PERUBAHAN
                            </button>
                        </div>
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
                document.getElementById('profilePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>