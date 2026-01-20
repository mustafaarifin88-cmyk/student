<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Activity | <?= isset($title) ? $title : 'Dashboard' ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            color: #5a5c69;
        }

        .main-header {
            border-bottom: none;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
            background-color: #fff;
        }

        .main-header .nav-link {
            color: #d1d3e2;
        }
        
        .main-header .nav-link:hover {
            color: #4e73df;
        }

        .main-sidebar {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
        }

        .brand-link {
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .brand-link .brand-text {
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .nav-sidebar .nav-item .nav-link {
            color: rgba(255,255,255,.8);
            font-weight: 500;
            margin-bottom: 5px;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .nav-sidebar .nav-item .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .nav-sidebar .nav-item .nav-link.active {
            background-color: #fff;
            color: #4e73df;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-sidebar .nav-item .nav-link.active i {
            color: #4e73df;
        }

        .content-wrapper {
            background-color: #f3f4f6;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 15px 15px 0 0 !important;
            padding: 1rem 1.25rem;
        }

        .card-title {
            color: #4e73df;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn {
            border-radius: 50px;
            padding: 0.375rem 1rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .form-control {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .main-footer {
            background-color: #fff;
            border-top: none;
            box-shadow: 0 -0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            font-size: 0.9rem;
        }

        .table thead th {
            background-color: #4e73df;
            color: #fff;
            border: none;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table thead th:first-child {
            border-top-left-radius: 10px;
        }
        
        .table thead th:last-child {
            border-top-right-radius: 10px;
        }

        .user-panel .info a {
            color: #fff !important;
            font-weight: 600;
        }
        
        .elevation-2 {
            box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23) !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: #5a5c69;"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <div class="d-flex align-items-center">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                <?= session()->get('nama_lengkap') ?>
            </span>
            <?php 
                $fotoProfil = session()->get('foto') ? session()->get('foto') : 'default.png';
            ?>
            <img src="<?= base_url('uploads/profil/' . $fotoProfil) ?>" class="img-circle elevation-1" alt="User Image" style="width: 30px; height: 30px; object-fit: cover;">
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow animated--grow-in" style="border-radius: 15px; border: none;">
          <div class="dropdown-header text-center bg-light" style="border-radius: 15px 15px 0 0;">
             <strong><?= session()->get('username') ?></strong>
             <br>
             <small class="text-muted"><?= ucfirst(session()->get('role')) ?></small>
          </div>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url(session()->get('role') . '/profile') ?>" class="dropdown-item">
            <i class="fas fa-user mr-2 text-primary"></i> Edit Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('auth/logout') ?>" class="dropdown-item text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <?= $this->include('layouts/sidebar') ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0" style="color: #5a5c69; font-weight: 700;"><?= isset($title) ? $title : '' ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right bg-transparent p-0">
              <li class="breadcrumb-item"><a href="#" style="color: #4e73df;">Home</a></li>
              <li class="breadcrumb-item active"><?= isset($title) ? $title : '' ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid pb-5">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 15px;">
                <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 15px;">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?= date('Y') ?> Student Activity.</strong> All rights reserved.
  </footer>

</div>

<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dynamic-form.js') ?>"></script>

<script>
    $(document).ready(function() {
        // Custom file input label
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html>