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
    .btn-gradient {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        border: none;
        color: white;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.3);
        transition: transform 0.2s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        color: white;
    }
    .preview-box {
        background: linear-gradient(90deg, rgba(78, 84, 200, 0.9) 0%, rgba(143, 148, 251, 0.8) 100%);
        border-radius: 15px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
    }
</style>

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card card-modern">
            <div class="card-header card-header-gradient">
                <h5 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-cogs mr-2"></i> Pengaturan Kelas
                </h5>
            </div>
            
            <div class="card-body p-4 p-md-5">
                
                <h6 class="font-weight-bold text-gray-700 mb-3">Preview Tampilan di Dashboard Siswa:</h6>
                <div class="preview-box">
                    <h2 class="font-weight-bold mb-1">Assalamualaikum, (Nama Siswa)! 👋</h2>
                    <p class="mb-0 small" style="opacity: 0.9;" id="text-preview">
                        <?= $kelas['pesan_motivasi'] ?>
                    </p>
                </div>

                <form action="<?= base_url('walas/pengaturan/update') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">Pesan Motivasi / Sambutan</label>
                        <textarea name="pesan_motivasi" id="pesan_input" class="form-control" rows="4" style="border-radius: 15px; border: 2px solid #e3e6f0;" placeholder="Tuliskan kata-kata penyemangat untuk siswa Anda..."><?= $kelas['pesan_motivasi'] ?></textarea>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle mr-1"></i> Pesan ini akan muncul di halaman utama (dashboard) setiap siswa di kelas Anda.
                        </small>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-gradient px-5">
                            <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Live Preview Script
    const textInput = document.getElementById('pesan_input');
    const textPreview = document.getElementById('text-preview');

    textInput.addEventListener('input', function() {
        if(this.value.trim() === '') {
            textPreview.innerText = 'Semangat belajar dan kumpulkan poin!';
        } else {
            textPreview.innerText = this.value;
        }
    });
</script>
<?= $this->endSection() ?>