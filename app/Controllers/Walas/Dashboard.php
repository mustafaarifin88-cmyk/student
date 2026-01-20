<?php

namespace App\Controllers\Walas;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\KegiatanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('id');
        $guruModel = new GuruModel();
        $kelasModel = new KelasModel();
        $siswaModel = new SiswaModel();
        $kegiatanModel = new KegiatanModel();

        $guru = $guruModel->where('user_id', $userId)->first();
        
        $kelas = null;
        $totalSiswa = 0;
        $totalKegiatan = 0;
        $namaKelas = 'Belum Ada Kelas';

        if ($guru) {
            $kelas = $kelasModel->where('wali_kelas_id', $guru['id'])->first();
            $totalKegiatan = $kegiatanModel->where('wali_kelas_id', $guru['id'])->countAllResults();

            if ($kelas) {
                $totalSiswa = $siswaModel->where('kelas_id', $kelas['id'])->countAllResults();
                $namaKelas = $kelas['nama_kelas'];
            }
        }

        $data = [
            'title'          => 'Dashboard Wali Kelas',
            'guru'           => $guru,
            'kelas'          => $kelas,
            'nama_kelas'     => $namaKelas,
            'total_siswa'    => $totalSiswa,
            'total_kegiatan' => $totalKegiatan
        ];

        return view('walas/dashboard', $data);
    }
}