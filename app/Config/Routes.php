<?php

namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'role_auth:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    $routes->get('sekolah', 'Admin\Sekolah::index');
    $routes->post('sekolah/update', 'Admin\Sekolah::update');

    $routes->get('kelas', 'Admin\Kelas::index');
    $routes->get('kelas/create', 'Admin\Kelas::create');
    $routes->post('kelas/store', 'Admin\Kelas::store');
    $routes->get('kelas/edit/(:num)', 'Admin\Kelas::edit/$1');
    $routes->post('kelas/update/(:num)', 'Admin\Kelas::update/$1');
    $routes->get('kelas/delete/(:num)', 'Admin\Kelas::delete/$1');
    $routes->post('kelas/import', 'Admin\Kelas::import');
    $routes->get('kelas/template', 'Admin\Kelas::downloadTemplate');

    $routes->get('guru', 'Admin\Guru::index');
    $routes->get('guru/create', 'Admin\Guru::create');
    $routes->post('guru/store', 'Admin\Guru::store');
    $routes->get('guru/edit/(:num)', 'Admin\Guru::edit/$1');
    $routes->post('guru/update/(:num)', 'Admin\Guru::update/$1');
    $routes->get('guru/delete/(:num)', 'Admin\Guru::delete/$1');
    $routes->post('guru/import', 'Admin\Guru::import');
    $routes->get('guru/template', 'Admin\Guru::downloadTemplate');

    $routes->get('siswa', 'Admin\Siswa::index');
    $routes->get('siswa/create', 'Admin\Siswa::create');
    $routes->post('siswa/store', 'Admin\Siswa::store');
    $routes->get('siswa/edit/(:num)', 'Admin\Siswa::edit/$1');
    $routes->post('siswa/update/(:num)', 'Admin\Siswa::update/$1');
    $routes->get('siswa/delete/(:num)', 'Admin\Siswa::delete/$1');
    $routes->post('siswa/import', 'Admin\Siswa::import');
    $routes->get('siswa/template', 'Admin\Siswa::downloadTemplate');

    $routes->get('user', 'Admin\User::index');
    $routes->post('user/store', 'Admin\User::store');
    $routes->post('user/update/(:num)', 'Admin\User::update/$1');
    $routes->get('user/delete/(:num)', 'Admin\User::delete/$1');

    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');

    $routes->get('laporan/kegiatan', 'Admin\Laporan::kegiatan');
    $routes->get('laporan/ranking', 'Admin\Laporan::ranking');
});

$routes->group('walas', ['filter' => 'role_auth:walas'], function ($routes) {
    $routes->get('dashboard', 'Walas\Dashboard::index');

    $routes->get('profile', 'Walas\Profile::index');
    $routes->post('profile/update', 'Walas\Profile::update');

    $routes->get('siswa', 'Walas\Siswa::index');
    $routes->post('siswa/store', 'Walas\Siswa::store');
    $routes->post('siswa/update/(:num)', 'Walas\Siswa::update/$1');
    $routes->get('siswa/delete/(:num)', 'Walas\Siswa::delete/$1');

    $routes->get('kegiatan', 'Walas\Kegiatan::index');
    $routes->get('kegiatan/create', 'Walas\Kegiatan::create');
    $routes->post('kegiatan/store', 'Walas\Kegiatan::store');
    $routes->get('kegiatan/edit/(:num)', 'Walas\Kegiatan::edit/$1');
    $routes->post('kegiatan/update/(:num)', 'Walas\Kegiatan::update/$1');
    $routes->get('kegiatan/delete/(:num)', 'Walas\Kegiatan::delete/$1');

    $routes->get('laporan/kegiatan', 'Walas\Laporan::kegiatan');
    $routes->get('laporan/ranking', 'Walas\Laporan::ranking');
});

$routes->group('siswa', ['filter' => 'role_auth:siswa'], function ($routes) {
    $routes->get('dashboard', 'Siswa\Dashboard::index');

    $routes->get('tugas', 'Siswa\Tugas::index');
    $routes->post('tugas/submit', 'Siswa\Tugas::submit');

    $routes->get('laporan', 'Siswa\Laporan::index');
    $routes->get('laporan/cetak_pdf', 'Siswa\Laporan::cetakPDF');
    $routes->get('laporan/cetak_excel', 'Siswa\Laporan::cetakExcel');
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}