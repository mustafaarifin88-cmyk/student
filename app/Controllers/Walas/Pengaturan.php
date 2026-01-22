<?php

namespace App\Controllers\Walas;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\GuruModel;

class Pengaturan extends BaseController
{
    protected $kelasModel;
    protected $guruModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
    }

    private function getKelasData()
    {
        $userId = session()->get('id');
        $guru = $this->guruModel->where('user_id', $userId)->first();
        if ($guru) {
            return $this->kelasModel->where('wali_kelas_id', $guru['id'])->first();
        }
        return null;
    }

    public function index()
    {
        $kelas = $this->getKelasData();

        if (!$kelas) {
            return redirect()->to('/walas/dashboard')->with('error', 'Anda belum memiliki kelas binaan.');
        }

        $data = [
            'title' => 'Pengaturan Kelas',
            'kelas' => $kelas
        ];

        return view('walas/pengaturan/index', $data);
    }

    public function update()
    {
        $kelas = $this->getKelasData();

        if (!$kelas) {
            return redirect()->to('/walas/dashboard')->with('error', 'Kelas tidak ditemukan.');
        }

        if (!$this->validate([
            'pesan_motivasi' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->update($kelas['id'], [
            'pesan_motivasi' => $this->request->getPost('pesan_motivasi')
        ]);

        return redirect()->to('/walas/pengaturan')->with('success', 'Pesan motivasi berhasil diperbarui.');
    }
}