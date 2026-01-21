<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Zone | <?= isset($title) ? $title : 'Activity' ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/student-theme.css') ?>">

    <style>
        .navbar-light .navbar-nav .nav-link {
            color: #555;
            font-weight: 600;
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: #6a11cb;
        }
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .user-img-circle {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #6a11cb;
        }
        .dropdown-item i {
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    
    <div class="student-wrapper">
        <canvas id="confetti-canvas" class="confetti-canvas"></canvas>

        <nav class="navbar navbar-expand-lg navbar-light student-navbar">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="<?= base_url('siswa/dashboard') ?>">
                    <i class="fas fa-rocket mr-2 text-primary"></i> STUDENT ZONE
                </a>
                <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fas fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('siswa/dashboard') ?>">
                                <i class="fas fa-th-large mr-1 d-lg-none"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('siswa/tugas') ?>">
                                <i class="fas fa-tasks mr-1 d-lg-none"></i> Tugas Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('siswa/laporan') ?>">
                                <i class="fas fa-chart-line mr-1 d-lg-none"></i> Laporan
                            </a>
                        </li>
                        <li class="nav-item dropdown ml-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-dark small"><?= session()->get('nama_lengkap') ?></span>
                                <?php $foto = session()->get('foto') ? session()->get('foto') : 'default.png'; ?>
                                <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="user-img-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('siswa/profile') ?>">
                                    <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-primary"></i>
                                    Edit Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4 pb-5">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success border-0 shadow-sm animate-pop" style="border-radius: 15px; background-color: #d4edda; color: #155724;">
                    <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm animate-pop" style="border-radius: 15px; background-color: #f8d7da; color: #721c24;">
                    <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('info')): ?>
                <div class="alert alert-info border-0 shadow-sm animate-pop" style="border-radius: 15px; background-color: #d1ecf1; color: #0c5460;">
                    <i class="fas fa-info-circle mr-2"></i> <?= session()->getFlashdata('info') ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

    <script>
        $(document).ready(function() {
            <?php if(session()->getFlashdata('confetti')): ?>
                var duration = 3 * 1000;
                var animationEnd = Date.now() + duration;
                var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

                function randomInRange(min, max) {
                  return Math.random() * (max - min) + min;
                }

                var interval = setInterval(function() {
                  var timeLeft = animationEnd - Date.now();

                  if (timeLeft <= 0) {
                    return clearInterval(interval);
                  }

                  var particleCount = 50 * (timeLeft / duration);
                  confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                  confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
                }, 250);
            <?php endif; ?>
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>