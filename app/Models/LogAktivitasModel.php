<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAktivitasModel extends Model
{
    protected $table            = 'log_aktivitas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kegiatan_id', 'siswa_id', 'total_poin_diperoleh', 'bukti_foto', 'tanggal_dikerjakan'];

    protected $useTimestamps = true;
    protected $createdField  = 'tanggal_dikerjakan';
    protected $updatedField  = '';

    public function getLogsBySiswa($siswaId, $startDate = null, $endDate = null)
    {
        $this->select('log_aktivitas.*, kegiatan.judul, kegiatan.instruksi, kegiatan.tipe');
        $this->join('kegiatan', 'kegiatan.id = log_aktivitas.kegiatan_id');
        $this->where('log_aktivitas.siswa_id', $siswaId);

        if ($startDate && $endDate) {
            $this->where('log_aktivitas.tanggal_dikerjakan >=', $startDate . ' 00:00:00');
            $this->where('log_aktivitas.tanggal_dikerjakan <=', $endDate . ' 23:59:59');
        }

        $this->orderBy('log_aktivitas.tanggal_dikerjakan', 'DESC');

        return $this->findAll();
    }

    // Method ini yang sebelumnya hilang/menyebabkan error
    public function cekStatusPengerjaan($siswaId, $kegiatanId, $tipeKegiatan)
    {
        // Reset query builder untuk memastikan tidak ada kondisi sisa
        $this->where('siswa_id', $siswaId)
             ->where('kegiatan_id', $kegiatanId);

        if ($tipeKegiatan == 'harian') {
            // Jika harian, cek apakah SUDAH dikerjakan HARI INI
            // Menggunakan 'like' untuk mencocokkan tanggal YYYY-MM-DD di awal string datetime
            $today = date('Y-m-d');
            $this->like('tanggal_dikerjakan', $today, 'after'); 
        } 
        // Jika 'sekali', tidak perlu filter tanggal (cek histori selamanya)

        return $this->first();
    }

    public function cekSudahDikerjakan($siswaId, $kegiatanId)
    {
        return $this->where('siswa_id', $siswaId)
                    ->where('kegiatan_id', $kegiatanId)
                    ->first();
    }

    public function getLaporanByKelas($kelasId, $startDate = null, $endDate = null)
    {
        $this->select('log_aktivitas.*, kegiatan.judul, users.nama_lengkap as nama_siswa, siswa.nisn, kegiatan.tipe');
        $this->join('siswa', 'siswa.id = log_aktivitas.siswa_id');
        $this->join('users', 'users.id = siswa.user_id');
        $this->join('kegiatan', 'kegiatan.id = log_aktivitas.kegiatan_id');
        $this->where('siswa.kelas_id', $kelasId);

        if ($startDate && $endDate) {
            $this->where('log_aktivitas.tanggal_dikerjakan >=', $startDate . ' 00:00:00');
            $this->where('log_aktivitas.tanggal_dikerjakan <=', $endDate . ' 23:59:59');
        }

        $this->orderBy('log_aktivitas.tanggal_dikerjakan', 'DESC');

        return $this->findAll();
    }
}