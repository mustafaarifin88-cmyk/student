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
    .custom-select-modern {
        border-radius: 10px;
        height: 48px;
        border: 1px solid #e3e6f0;
        background-color: #f8f9fc;
    }
</style>

<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="card card-modern">
            <div class="card-header card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-white">
                    <i class="fas <?= isset($kelas) ? 'fa-edit' : 'fa-plus' ?> mr-2"></i> 
                    <?= $title ?>
                </h5>
                <a href="<?= base_url('admin/kelas') ?>" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm text-primary font-weight-bold">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <?php $action = isset($kelas) ? 'update/' . $kelas['id'] : 'store'; ?>
                <form action="<?= base_url('admin/kelas/' . $action) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-gray-600 text-uppercase">Nama Kelas</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-text-modern">
                                    <i class="fas fa-layer-group text-gray-400"></i>
                                </span>
                            </div>
                            <input type="text" name="nama_kelas" class="form-control form-control-modern with-icon" placeholder="Contoh: X IPA 1" value="<?= isset($kelas) ? $kelas['nama_kelas'] : old('nama_kelas') ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-gray-600 text-uppercase">Wali Kelas</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-text-modern">
                                    <i class="fas fa-chalkboard-teacher text-gray-400"></i>
                                </span>
                            </div>
                            <select name="wali_kelas_id" class="custom-select custom-select-modern" style="border-left: none; border-radius: 0 10px 10px 0;">
                                <option value="">-- Pilih Wali Kelas --</option>
                                <?php foreach ($guru as $g): ?>
                                    <?php 
                                        $selected = '';
                                        // Logic: if editing and this teacher is the current walas
                                        if (isset($kelas) && $kelas['wali_kelas_id'] == $g['id']) {
                                            $selected = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $g['id'] ?>" <?= $selected ?>>
                                        <?= $g['nama_lengkap'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <small class="text-muted ml-2">Pilih guru yang akan menjadi wali kelas ini.</small>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <a href="<?= base_url('admin/kelas') ?>" class="btn btn-light-modern mr-3">Batal</a>
                        <button type="submit" class="btn btn-gradient px-5">
                            <i class="fas fa-save mr-2"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>