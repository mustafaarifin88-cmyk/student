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
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
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
        border-color: #1cc88a;
        box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.1);
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
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        border: none;
        color: white;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.3);
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
    .criteria-card {
        background-color: #fff;
        border: 1px dashed #d1d3e2;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
    }
    .add-btn-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
</style>

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card card-modern">
            <div class="card-header card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-white">
                    <i class="fas <?= isset($kegiatan) ? 'fa-edit' : 'fa-plus-circle' ?> mr-2"></i> 
                    <?= $title ?>
                </h5>
                <a href="<?= base_url('walas/kegiatan') ?>" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm text-success font-weight-bold">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <?php $action = isset($kegiatan) ? 'update/' . $kegiatan['id'] : 'store'; ?>
                <form action="<?= base_url('walas/kegiatan/' . $action) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <h6 class="text-uppercase font-weight-bold text-gray-500 mb-3 small">Informasi Dasar</h6>
                    
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Judul Kegiatan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-text-modern">
                                    <i class="fas fa-heading text-gray-400"></i>
                                </span>
                            </div>
                            <input type="text" name="judul" class="form-control form-control-modern with-icon" placeholder="Contoh: Sholat Zuhur Berjamaah" value="<?= isset($kegiatan) ? $kegiatan['judul'] : old('judul') ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Instruksi Tugas</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-text-modern h-100 rounded-left" style="border-radius: 10px 0 0 10px;">
                                    <i class="fas fa-align-left text-gray-400"></i>
                                </span>
                            </div>
                            <textarea name="instruksi" class="form-control form-control-modern with-icon" rows="3" placeholder="Jelaskan apa yang harus dilakukan siswa..." required><?= isset($kegiatan) ? $kegiatan['instruksi'] : old('instruksi') ?></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase font-weight-bold text-gray-500 small m-0">Kriteria Penilaian & Poin</h6>
                        <!-- Change Class: add_criteria_btn (was add_field_button) to prevent conflict -->
                        <button class="btn btn-sm btn-success rounded-pill px-3 add_criteria_btn" type="button">
                            <i class="fas fa-plus mr-1"></i> Tambah Kriteria
                        </button>
                    </div>

                    <div class="criteria-card bg-light">
                        <!-- Change Class: criteria_fields_wrap (was input_fields_wrap) to prevent conflict -->
                        <div class="criteria_fields_wrap">
                            <?php if (isset($kriteria) && !empty($kriteria)) : ?>
                                <?php foreach ($kriteria as $k) : ?>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-7 mb-2 mb-md-0">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-0 text-muted">
                                                        <i class="fas fa-check-circle"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="deskripsi[]" class="form-control form-control-modern border-0 shadow-sm" placeholder="Deskripsi (misal: Tepat Waktu)" value="<?= $k['deskripsi'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2 mb-md-0">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-0 text-muted">Pts</span>
                                                </div>
                                                <input type="number" name="poin[]" class="form-control form-control-modern border-0 shadow-sm" placeholder="10" value="<?= $k['poin'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <button class="btn btn-danger btn-sm rounded-circle shadow-sm remove_field_custom" type="button" style="width: 35px; height: 35px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-7 mb-2 mb-md-0">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-0 text-muted">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="deskripsi[]" class="form-control form-control-modern border-0 shadow-sm" placeholder="Deskripsi (misal: Melaksanakan Kegiatan)" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-0 text-muted">Pts</span>
                                            </div>
                                            <input type="number" name="poin[]" class="form-control form-control-modern border-0 shadow-sm" placeholder="Poin" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-right">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <small class="text-muted font-italic ml-1">* Klik tombol tambah untuk memasukkan kriteria penilaian lainnya.</small>

                    <div class="d-flex justify-content-end mt-5">
                        <a href="<?= base_url('walas/kegiatan') ?>" class="btn btn-light-modern mr-3">Batal</a>
                        <button type="submit" class="btn btn-gradient px-5">
                            <i class="fas fa-save mr-2"></i> Simpan Kegiatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Menggunakan selector class yang BERBEDA agar tidak bentrok dengan script global
        var wrapper = document.querySelector(".criteria_fields_wrap");
        var addButton = document.querySelector(".add_criteria_btn");
        var maxFields = 10;
        
        // Hitung jumlah row yang sudah ada
        var x = document.querySelectorAll(".criteria_fields_wrap .row").length;

        if(addButton && wrapper) {
            addButton.addEventListener("click", function(e) {
                e.preventDefault();
                if (x < maxFields) {
                    x++;
                    var div = document.createElement('div');
                    div.className = 'row mb-3 align-items-center animate__animated animate__fadeIn';
                    div.innerHTML = `
                        <div class="col-md-7 mb-2 mb-md-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-muted">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>
                                <input type="text" name="deskripsi[]" class="form-control form-control-modern border-0 shadow-sm" placeholder="Deskripsi Kriteria" required>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-0 text-muted">Pts</span>
                                </div>
                                <input type="number" name="poin[]" class="form-control form-control-modern border-0 shadow-sm" placeholder="Poin" required>
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <button class="btn btn-danger btn-sm rounded-circle shadow-sm remove_field_custom" type="button" style="width: 35px; height: 35px;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    `;
                    wrapper.appendChild(div);
                }
            });

            wrapper.addEventListener("click", function(e) {
                // Event delegation untuk tombol hapus
                if (e.target.closest(".remove_field_custom")) {
                    e.preventDefault();
                    e.target.closest(".row").remove();
                    x--;
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>