<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table            = 'kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['wali_kelas_id', 'judul', 'instruksi', 'tipe', 'tanggal_dibuat'];

    protected $useTimestamps = true;
    protected $createdField  = 'tanggal_dibuat';
    protected $updatedField  = ''; 

    public function getKegiatanByWalas($waliKelasId)
    {
        return $this->where('wali_kelas_id', $waliKelasId)
                    ->orderBy('tanggal_dibuat', 'DESC')
                    ->findAll();
    }

    public function getKegiatanWithGuru()
    {
        $this->select('kegiatan.*, users.nama_lengkap as nama_guru');
        $this->join('guru', 'guru.id = kegiatan.wali_kelas_id');
        $this->join('users', 'users.id = guru.user_id');
        $this->orderBy('kegiatan.tanggal_dibuat', 'DESC');
        
        return $this->findAll();
    }
}