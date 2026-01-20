<style>
    /* Animasi Gradient Background */
    @keyframes sidebar-gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .sidebar-radiant {
        background: linear-gradient(-45deg, #4e73df, #224abe, #667eea, #764ba2);
        background-size: 400% 400%;
        animation: sidebar-gradient 15s ease infinite;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        
        /* Flexbox Fix untuk Layout Sidebar */
        display: flex !important;
        flex-direction: column !important;
        height: 100vh !important;
        padding-bottom: 0 !important;
    }

    /* Area Logo - Fixed di Atas */
    .brand-link-modern {
        flex: 0 0 auto; /* Tidak menyusut, tinggi sesuai konten */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        background: rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .brand-link-modern:hover {
        background: rgba(0, 0, 0, 0.2);
    }

    /* Area Menu - Scrollable Mengisi Sisa Ruang */
    .sidebar {
        flex: 1 1 auto; /* Mengisi sisa ruang */
        overflow-y: auto !important; /* Paksa Scroll Vertikal */
        overflow-x: hidden;
        width: 100%;
        padding-bottom: 50px; /* Ruang di bawah agar menu terakhir tidak kepotong */
        
        /* Custom Scrollbar untuk Webkit (Chrome/Safari) agar tidak merusak desain */
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
    }

    .sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 20px;
    }

    /* Styling User Panel */
    .user-panel-modern {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 15px;
        margin: 15px 10px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        transition: transform 0.2s;
    }

    .user-panel-modern:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.15);
    }

    /* Navigasi Modern */
    .nav-sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 10px !important;
        margin-bottom: 5px;
        transition: all 0.2s;
        white-space: normal; /* Mencegah teks panjang merusak layout */
    }

    .nav-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
        padding-left: 1.5rem;
    }

    .nav-sidebar .nav-link.active {
        background-color: #fff !important;
        color: #4e73df !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-weight: 600;
    }

    .nav-sidebar .nav-link.active i {
        color: #4e73df !important;
    }

    .nav-header-modern {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 1rem 1rem 0.5rem;
        font-weight: 700;
        margin-top: 10px;
    }

    .logout-btn {
        background: rgba(231, 74, 59, 0.8) !important;
        backdrop-filter: blur(5px);
        margin-top: 20px;
        margin-bottom: 40px; /* Tambahan margin bawah */
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .logout-btn:hover {
        background: #e74a3b !important;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-radiant">
    <!-- Brand Logo Area -->
    <a href="#" class="brand-link-modern text-decoration-none">
        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mb-2" style="width: 50px; height: 50px;">
            <i class="fas fa-graduation-cap fa-lg text-primary"></i>
        </div>
        <span class="brand-text font-weight-bold text-white h5 mb-0" style="letter-spacing: 1px;">STUDENT APP</span>
        <small class="text-white-50" style="font-size: 0.7rem;">Sistem Informasi Siswa</small>
    </a>

    <!-- Sidebar Scroll Area -->
    <div class="sidebar">
        <!-- User Panel Modern -->
        <div class="user-panel-modern">
            <div class="image">
                <?php $foto = session()->get('foto') ? session()->get('foto') : 'default.png'; ?>
                <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="img-circle elevation-2" alt="User Image" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #fff;">
            </div>
            <div class="info pl-3">
                <a href="<?= base_url(session()->get('role') . '/profile') ?>" class="d-block text-white font-weight-bold text-decoration-none" style="line-height: 1.2;">
                    <?= substr(session()->get('nama_lengkap'), 0, 15) ?>
                </a>
                <span class="badge badge-light mt-1 text-primary px-2" style="font-size: 0.7rem; font-weight: 600;"><?= strtoupper(session()->get('role')) ?></span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                
                <?php 
                $uri = service('uri'); 
                $role = session()->get('role');
                $segment2 = $uri->getSegment(2);
                $segment3 = $uri->getTotalSegments() > 2 ? $uri->getSegment(3) : '';
                ?>

                <li class="nav-item mb-2">
                    <a href="<?= base_url($role . '/dashboard') ?>" class="nav-link <?= ($segment2 == 'dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if($role == 'admin'): ?>
                    <div class="nav-header-modern">Master Data</div>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('admin/sekolah') ?>" class="nav-link <?= ($segment2 == 'sekolah') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-university"></i>
                            <p>Profil Sekolah</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('admin/kelas') ?>" class="nav-link <?= ($segment2 == 'kelas') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Data Kelas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url('admin/guru') ?>" class="nav-link <?= ($segment2 == 'guru') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Data Guru</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url('admin/siswa') ?>" class="nav-link <?= ($segment2 == 'siswa') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Data Siswa</p>
                        </a>
                    </li>

                    <div class="nav-header-modern">Manajemen</div>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('admin/user') ?>" class="nav-link <?= ($segment2 == 'user') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Admin Users</p>
                        </a>
                    </li>

                    <div class="nav-header-modern">Laporan</div>

                    <li class="nav-item">
                        <a href="<?= base_url('admin/laporan/kegiatan') ?>" class="nav-link <?= ($segment2 == 'laporan' && $segment3 == 'kegiatan') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>Laporan Kegiatan</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('admin/laporan/ranking') ?>" class="nav-link <?= ($segment2 == 'laporan' && $segment3 == 'ranking') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-medal"></i>
                            <p>Ranking Siswa</p>
                        </a>
                    </li>

                <?php elseif($role == 'walas'): ?>
                    <div class="nav-header-modern">Kelas Saya</div>

                    <li class="nav-item">
                        <a href="<?= base_url('walas/siswa') ?>" class="nav-link <?= ($segment2 == 'siswa') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Data Siswa</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url('walas/kegiatan') ?>" class="nav-link <?= ($segment2 == 'kegiatan') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Kegiatan & Tugas</p>
                        </a>
                    </li>

                    <div class="nav-header-modern">Laporan</div>

                    <li class="nav-item">
                        <a href="<?= base_url('walas/laporan/kegiatan') ?>" class="nav-link <?= ($segment2 == 'laporan' && $segment3 == 'kegiatan') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Laporan Kegiatan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url('walas/laporan/ranking') ?>" class="nav-link <?= ($segment2 == 'laporan' && $segment3 == 'ranking') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-trophy"></i>
                            <p>Ranking Kelas</p>
                        </a>
                    </li>
                <?php endif; ?>

                <div class="nav-header-modern">Akun</div>
                
                <li class="nav-item">
                    <a href="<?= base_url($role . '/profile') ?>" class="nav-link <?= ($segment2 == 'profile') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Edit Profil</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link logout-btn text-white">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Keluar Aplikasi</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>