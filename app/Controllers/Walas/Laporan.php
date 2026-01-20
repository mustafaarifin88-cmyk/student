<?php

namespace App\Controllers\Walas;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

class Laporan extends BaseController
{
    protected $logModel;
    protected $siswaModel;
    protected $guruModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel();
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
    }

    private function getKelasId()
    {
        $userId = session()->get('id');
        $guru = $this->guruModel->where('user_id', $userId)->first();
        if ($guru) {
            $kelas = $this->kelasModel->where('wali_kelas_id', $guru['id'])->first();
            return $kelas ? $kelas['id'] : null;
        }
        return null;
    }

    public function kegiatan()
    {
        $kelasId = $this->getKelasId();
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
            'title'          => 'Laporan Kegiatan Kelas',
            'logs'           => $logs,
            'selected_waktu' => $waktu
        ];

        return view('walas/laporan/kegiatan', $data);
    }

    public function ranking()
    {
        $kelasId = $this->getKelasId();
        $ranking = [];

        if ($kelasId) {
            $ranking = $this->siswaModel->getSiswaByKelas($kelasId);
        }

        $data = [
            'title'   => 'Ranking Siswa Kelas',
            'ranking' => $ranking
        ];

        return view('walas/laporan/ranking', $data);
    }
}