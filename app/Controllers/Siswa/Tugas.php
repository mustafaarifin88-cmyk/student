<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\KegiatanModel;
use App\Models\KriteriaModel;
use App\Models\LogAktivitasModel;
use App\Models\KelasModel;
use App\Models\GuruModel;

class Tugas extends BaseController
{
    protected $siswaModel;
    protected $kegiatanModel;
    protected $kriteriaModel;
    protected $logModel;
    protected $kelasModel;
    protected $guruModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kegiatanModel = new KegiatanModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->logModel = new LogAktivitasModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to('/auth/logout');
        }

        $kelas = $this->kelasModel->find($siswa['kelas_id']);
        
        $daftarTugas = [];
        if ($kelas && $kelas['wali_kelas_id']) {
            $kegiatan = $this->kegiatanModel->getKegiatanByWalas($kelas['wali_kelas_id']);
            
            foreach ($kegiatan as $k) {
                $status = $this->logModel->cekSudahDikerjakan($siswa['id'], $k['id']);
                $kriteria = $this->kriteriaModel->getByKegiatan($k['id']);
                
                $daftarTugas[] = [
                    'kegiatan' => $k,
                    'kriteria' => $kriteria,
                    'status'   => $status ? true : false,
                    'nilai'    => $status ? $status['total_poin_diperoleh'] : 0
                ];
            }
        }

        $data = [
            'title' => 'Daftar Tugas',
            'tugas' => $daftarTugas
        ];

        return view('siswa/tugas/index', $data);
    }

    public function submit()
    {
        $userId = session()->get('id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();
        $kegiatanId = $this->request->getPost('kegiatan_id');
        $selectedKriteria = $this->request->getPost('kriteria'); 

        $sudahDikerjakan = $this->logModel->cekSudahDikerjakan($siswa['id'], $kegiatanId);
        if ($sudahDikerjakan) {
            return redirect()->back()->with('error', 'Tugas ini sudah dikerjakan.');
        }

        $totalPoin = 0;
        $detailLog = [];

        if ($selectedKriteria) {
            foreach ($selectedKriteria as $kriteriaId) {
                $kriteria = $this->kriteriaModel->find($kriteriaId);
                if ($kriteria) {
                    $totalPoin += $kriteria['poin'];
                    $detailLog[] = $kriteriaId;
                }
            }
        }

        $this->logModel->save([
            'kegiatan_id' => $kegiatanId,
            'siswa_id'    => $siswa['id'],
            'total_poin_diperoleh' => $totalPoin,
            'tanggal_dikerjakan'   => date('Y-m-d H:i:s')
        ]);

        $logId = $this->logModel->getInsertID();

        $db = \Config\Database::connect();
        $builder = $db->table('detail_log_aktivitas');
        
        foreach ($detailLog as $kid) {
            $builder->insert([
                'log_aktivitas_id' => $logId,
                'kriteria_id' => $kid
            ]);
        }

        $newTotalPoin = $siswa['total_poin'] + $totalPoin;
        $this->siswaModel->update($siswa['id'], ['total_poin' => $newTotalPoin]);

        return redirect()->to('/siswa/tugas')->with('success', 'Tugas berhasil dikirim. Anda mendapatkan ' . $totalPoin . ' poin!');
    }
}