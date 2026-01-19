<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'nisn', 'kelas_id', 'total_poin'];

    protected $useTimestamps = false;

    public function getSiswaLengkap($id = null)
    {
        $this->select('siswa.*, users.nama_lengkap, users.username, users.password, users.foto, users.role, kelas.nama_kelas');
        $this->join('users', 'users.id = siswa.user_id');
        $this->join('kelas', 'kelas.id = siswa.kelas_id', 'left');
        
        if ($id != null) {
            return $this->where('siswa.id', $id)->first();
        }

        return $this->findAll();
    }

    public function getSiswaByKelas($kelasId)
    {
        $this->select('siswa.*, users.nama_lengkap, users.username, users.foto, users.role, kelas.nama_kelas');
        $this->join('users', 'users.id = siswa.user_id');
        $this->join('kelas', 'kelas.id = siswa.kelas_id', 'left');
        $this->where('siswa.kelas_id', $kelasId);
        $this->orderBy('siswa.total_poin', 'DESC');
        
        return $this->findAll();
    }
}