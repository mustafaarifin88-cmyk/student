<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'guru';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'nip'];

    protected $useTimestamps = false;

    public function getGuruLengkap($id = null)
    {
        $this->select('guru.*, users.nama_lengkap, users.username, users.foto, users.role');
        $this->join('users', 'users.id = guru.user_id');
        
        if ($id != null) {
            return $this->where('guru.id', $id)->first();
        }

        return $this->findAll();
    }
}