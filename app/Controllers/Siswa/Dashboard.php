<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('id');
        $siswaModel = new SiswaModel();
        
        $siswa = $siswaModel->select('siswa.*, users.nama_lengkap, users.foto, kelas.pesan_motivasi, kelas.nama_kelas')
                            ->join('users', 'users.id = siswa.user_id')
                            ->join('kelas', 'kelas.id = siswa.kelas_id', 'left') 
                            ->where('siswa.user_id', $userId)
                            ->first();
        
        if (!$siswa) {
            return redirect()->to('/auth/logout');
        }

        $rankingKelas = $siswaModel->getSiswaByKelas($siswa['kelas_id']);
        
        $rankKelas = 1;
        $topSiswaKelas = null;
        $totalSiswaKelas = 0;
        
        if (!empty($rankingKelas)) {
            $totalSiswaKelas = count($rankingKelas);
            $topSiswaKelas = $rankingKelas[0];
            foreach ($rankingKelas as $index => $s) {
                if ($s['id'] == $siswa['id']) {
                    $rankKelas = $index + 1;
                    break;
                }
            }
        }

        $allSiswa = $siswaModel->select('siswa.*, users.nama_lengkap, users.foto, kelas.nama_kelas')
                              ->join('users', 'users.id = siswa.user_id')
                              ->join('kelas', 'kelas.id = siswa.kelas_id', 'left')
                              ->orderBy('total_poin', 'DESC')
                              ->findAll();

        $rankSekolah = 1;
        $topSiswaSekolah = null;
        $totalSiswaSekolah = 0;

        if (!empty($allSiswa)) {
            $totalSiswaSekolah = count($allSiswa);
            $topSiswaSekolah = $allSiswa[0];
            foreach ($allSiswa as $index => $s) {
                if ($s['id'] == $siswa['id']) {
                    $rankSekolah = $index + 1;
                    break;
                }
            }
        }

        $data = [
            'title'             => 'Dashboard Siswa',
            'siswa'             => $siswa,
            'rank_kelas'        => $rankKelas,
            'rank_sekolah'      => $rankSekolah,
            'top_siswa_kelas'   => $topSiswaKelas,
            'top_siswa_sekolah' => $topSiswaSekolah,
            'total_siswa_kelas' => $totalSiswaKelas,
            'total_siswa_sekolah' => $totalSiswaSekolah
        ];

        return view('siswa/dashboard', $data);
    }
}