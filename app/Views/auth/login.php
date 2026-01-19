<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Student Activity</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .card-modern {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: none;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .card-header-modern {
            background: transparent;
            padding: 40px 30px 20px;
            text-align: center;
            border: none;
        }

        .card-header-modern h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
            font-size: 24px;
        }

        .card-header-modern p {
            color: #888;
            font-size: 14px;
        }

        .card-body-modern {
            padding: 0 30px 40px;
        }

        .form-group-modern {
            position: relative;
            margin-bottom: 25px;
        }

        .form-control-modern {
            width: 100%;
            padding: 15px 20px 15px 45px;
            border-radius: 50px;
            border: 1px solid #e1e1e1;
            background: #f8f9fa;
            font-size: 14px;
            transition: all 0.3s ease;
            height: auto;
        }

        .form-control-modern:focus {
            border-color: #764ba2;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(118, 75, 162, 0.1);
        }

        .form-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-control-modern:focus + .form-icon {
            color: #764ba2;
        }

        .btn-modern {
            width: 100%;
            padding: 15px;
            border-radius: 50px;
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(118, 75, 162, 0.3);
            color: white;
        }

        .alert-modern {
            border-radius: 15px;
            font-size: 13px;
            border: none;
        }

        .brand-logo-circle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
        }
    </style>
</head>
<body>

<div class="login-card-container">
    <div class="card card-modern">
        <div class="card-header-modern">
            <div class="brand-logo-circle">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h2>Student Activity</h2>
            <p>Silakan login untuk melanjutkan</p>
        </div>
        
        <div class="card-body-modern">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-modern fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group-modern">
                    <input type="text" name="username" class="form-control form-control-modern" placeholder="Username" required autocomplete="off">
                    <i class="fas fa-user form-icon"></i>
                </div>

                <div class="form-group-modern">
                    <input type="password" name="password" class="form-control form-control-modern" placeholder="Password" required>
                    <i class="fas fa-lock form-icon"></i>
                </div>

                <button type="submit" class="btn btn-modern">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <small style="color: rgba(255,255,255,0.7);">&copy; <?= date('Y') ?> Student Activity App. All rights reserved.</small>
    </div>
</div>

<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

</body>
</html>