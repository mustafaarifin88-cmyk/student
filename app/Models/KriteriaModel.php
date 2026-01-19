<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModel extends Model
{
    protected $table            = 'kriteria_penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kegiatan_id', 'deskripsi', 'poin'];

    protected $useTimestamps = false;

    public function getByKegiatan($kegiatanId)
    {
        return $this->where('kegiatan_id', $kegiatanId)->findAll();
    }
}