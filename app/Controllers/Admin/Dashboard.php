<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;
use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $sekolahModel = new SekolahModel();
        $guruModel = new GuruModel();
        $siswaModel = new SiswaModel();
        $kelasModel = new KelasModel();

        $data = [
            'title'       => 'Dashboard Admin',
            'sekolah'     => $sekolahModel->first(),
            'total_guru'  => $guruModel->countAll(),
            'total_siswa' => $siswaModel->countAll(),
            'total_kelas' => $kelasModel->countAll(),
        ];

        return view('admin/dashboard', $data);
    }
}