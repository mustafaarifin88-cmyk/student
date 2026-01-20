<aside class="main-sidebar sidebar-dark-primary elevation-4" style="border-bottom-right-radius: 20px; overflow: hidden;">
    <a href="#" class="brand-link text-center pt-3 pb-3">
        <i class="fas fa-graduation-cap fa-2x text-white mb-2"></i>
        <span class="brand-text font-weight-bold d-block text-white" style="letter-spacing: 1px;">STUDENT APP</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="image">
                <?php $foto = session()->get('foto') ? session()->get('foto') : 'default.png'; ?>
                <img src="<?= base_url('uploads/profil/' . $foto) ?>" class="img-circle elevation-2" alt="User Image" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid rgba(255,255,255,0.8);">
            </div>
            <div class="info ml-2">
                <a href="#" class="d-block text-white font-weight-bold"><?= substr(session()->get('nama_lengkap'), 0, 15) ?></a>
                <small class="text-light" style="opacity: 0.8;"><i class="fas fa-circle text-success text-xs mr-1"></i> <?= ucfirst(session()->get('role')) ?></small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                
                <?php 
                $uri = service('uri'); 
                $role = session()->get('role');
                $segment2 = $uri->getSegment(2);
                $segment3 = $uri->getTotalSegments() > 2 ? $uri->getSegment(3) : '';
                ?>

                <li class="nav-item">
                    <a href="<?= base_url($role . '/dashboard') ?>" class="nav-link <?= ($segment2 == 'dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if($role == 'admin'): ?>
                    <li class="nav-header text-uppercase font-weight-bold mt-2" style="color: rgba(255,255,255,0.5); font-size: 0.8rem; letter-spacing: 1px;">Master Data</li>
                    
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

                    <li class="nav-header text-uppercase font-weight-bold mt-2" style="color: rgba(255,255,255,0.5); font-size: 0.8rem; letter-spacing: 1px;">Admin</li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('admin/user') ?>" class="nav-link <?= ($segment2 == 'user') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manajemen Admin</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase font-weight-bold mt-2" style="color: rgba(255,255,255,0.5); font-size: 0.8rem; letter-spacing: 1px;">Laporan</li>

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
                    <li class="nav-header text-uppercase font-weight-bold mt-2" style="color: rgba(255,255,255,0.5); font-size: 0.8rem; letter-spacing: 1px;">Kelas Saya</li>

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

                    <li class="nav-header text-uppercase font-weight-bold mt-2" style="color: rgba(255,255,255,0.5); font-size: 0.8rem; letter-spacing: 1px;">Laporan</li>

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

                <li class="nav-header text-uppercase font-weight-bold mt-2" style="color: rgba(255,255,255,0.5); font-size: 0.8rem; letter-spacing: 1px;">Pengaturan</li>
                
                <li class="nav-item">
                    <a href="<?= base_url($role . '/profile') ?>" class="nav-link <?= ($segment2 == 'profile') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Edit Profil</p>
                    </a>
                </li>
                
                <li class="nav-item mt-3">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link bg-danger text-white">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>