<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .school-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .bg-school-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    .profile-img-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }
    .school-logo-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 5px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .form-control-modern {
        border-radius: 10px;
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
    .btn-save {
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        transition: transform 0.2s;
    }
    .btn-save:hover {
        transform: translateY(-2px);
    }
</style>

<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12">
        <div class="card school-card">
            <div class="row no-gutters">
                <div class="col-md-5 bg-school-gradient text-white d-flex flex-column align-items-center justify-content-center p-5">
                    <div class="profile-img-container mb-4">
                        <?php if ($sekolah && $sekolah['logo']): ?>
                            <img src="<?= base_url('uploads/sekolah/' . $sekolah['logo']) ?>" alt="Logo Sekolah" class="school-logo-preview" id="preview-image">
                        <?php else: ?>
                            <img src="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" alt="Default Logo" class="school-logo-preview" id="preview-image">
                        <?php endif; ?>
                    </div>
                    <h3 class="font-weight-bold text-center mb-1"><?= $sekolah['nama_sekolah'] ?? 'Nama Sekolah Belum Diatur' ?></h3>
                    <p class="text-white-50 text-center mb-0 px-3"><?= $sekolah['alamat'] ?? 'Alamat belum diisi' ?></p>
                    <div class="mt-4">
                        <span class="badge badge-light px-3 py-2 rounded-pill text-primary font-weight-bold">
                            <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                        </span>
                    </div>
                </div>

                <div class="col-md-7 bg-white p-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="font-weight-bold text-gray-800 m-0">Edit Profil Sekolah</h4>
                        <i class="fas fa-pen-fancy text-gray-300 fa-2x"></i>
                    </div>

                    <form action="<?= base_url('admin/sekolah/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $sekolah['id'] ?? '' ?>">

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-gray-600 text-uppercase">Nama Sekolah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0 rounded-left" style="border-radius: 10px 0 0 10px; border-color: #e3e6f0;">
                                        <i class="fas fa-university text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" name="nama_sekolah" class="form-control form-control-modern border-left-0" style="border-radius: 0 10px 10px 0;" value="<?= $sekolah['nama_sekolah'] ?? '' ?>" placeholder="Masukkan nama sekolah..." required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-gray-600 text-uppercase">Alamat Lengkap</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0 rounded-left" style="border-radius: 10px 0 0 10px; border-color: #e3e6f0;">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                    </span>
                                </div>
                                <textarea name="alamat" class="form-control form-control-modern border-left-0" style="border-radius: 0 10px 10px 0;" rows="3" placeholder="Masukkan alamat sekolah..." required><?= $sekolah['alamat'] ?? '' ?></textarea>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-gray-600 text-uppercase">Update Logo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*" onchange="previewImage(this)">
                                <label class="custom-file-label form-control-modern" for="logo" style="border-radius: 10px;">Pilih file logo baru...</label>
                            </div>
                            <small class="text-muted mt-2 d-block">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        </div>

                        <div class="text-right mt-5">
                            <button type="submit" class="btn btn-primary btn-save btn-block">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
            
            var fileName = input.files[0].name;
            var label = input.nextElementSibling;
            label.innerText = fileName;
        }
    }
</script>
<?= $this->endSection() ?>