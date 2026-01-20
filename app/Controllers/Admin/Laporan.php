<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;

class Laporan extends BaseController
{
    protected $logModel;
    protected $kelasModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel();
        $this->kelasModel = new KelasModel();
        $this->siswaModel = new SiswaModel();
    }

    public function kegiatan()
    {
        $kelasId = $this->request->getVar('kelas');
        $waktu = $this->request->getVar('waktu');
        
        $startDate = null;
        $endDate = date('Y-m-d');

        if ($waktu) {
            switch ($waktu) {
                case '1_minggu':
                    $startDate = date('Y-m-d', strtotime('-1 week'));
                    break;
                case '1_bulan':
                    $startDate = date('Y-m-d', strtotime('-1 month'));
                    break;
                case '1_tahun':
                    $startDate = date('Y-m-d', strtotime('-1 year'));
                    break;
                default: 
                    $startDate = null; 
                    break;
            }
        }

        $logs = [];
        if ($kelasId) {
            $logs = $this->logModel->getLaporanByKelas($kelasId, $startDate, $endDate);
        }

        $data = [
            'title'    => 'Laporan Kegiatan Siswa',
            'kelas'    => $this->kelasModel->findAll(),
            'logs'     => $logs,
            'selected_kelas' => $kelasId,
            'selected_waktu' => $waktu
        ];

        return view('admin/laporan/kegiatan', $data);
    }

    public function ranking()
    {
        $kelasId = $this->request->getVar('kelas');

        $ranking = [];
        if ($kelasId) {
            $ranking = $this->siswaModel->getSiswaByKelas($kelasId);
        } else {
            $this->siswaModel->select('siswa.*, users.nama_lengkap, users.username, users.foto, users.role, kelas.nama_kelas');
            $this->siswaModel->join('users', 'users.id = siswa.user_id');
            $this->siswaModel->join('kelas', 'kelas.id = siswa.kelas_id', 'left');
            $this->siswaModel->orderBy('siswa.total_poin', 'DESC');
            $ranking = $this->siswaModel->findAll();
        }

        $data = [
            'title'          => 'Laporan Ranking Siswa',
            'kelas'          => $this->kelasModel->findAll(),
            'ranking'        => $ranking,
            'selected_kelas' => $kelasId
        ];

        return view('admin/laporan/ranking', $data);
    }
}