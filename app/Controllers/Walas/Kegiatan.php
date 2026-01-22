<?php

namespace App\Controllers\Walas;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\KriteriaModel;
use App\Models\GuruModel;

class Kegiatan extends BaseController
{
    protected $kegiatanModel;
    protected $kriteriaModel;
    protected $guruModel;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->guruModel = new GuruModel();
    }

    private function getGuruId()
    {
        $userId = session()->get('id');
        $guru = $this->guruModel->where('user_id', $userId)->first();
        return $guru ? $guru['id'] : null;
    }

    public function index()
    {
        $guruId = $this->getGuruId();
        
        if (!$guruId) {
            return redirect()->to('/walas/dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $data = [
            'title'    => 'Kegiatan Kelas',
            'kegiatan' => $this->kegiatanModel->getKegiatanByWalas($guruId)
        ];

        return view('walas/kegiatan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kegiatan Baru'
        ];
        return view('walas/kegiatan/form', $data);
    }

    public function store()
    {
        $guruId = $this->getGuruId();
        
        if (!$this->validate([
            'judul'       => 'required',
            'instruksi'   => 'required',
            'tipe'        => 'required|in_list[harian,sekali]',
            'deskripsi.*' => 'required',
            'poin.*'      => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kegiatanModel->save([
            'wali_kelas_id' => $guruId,
            'judul'         => $this->request->getPost('judul'),
            'instruksi'     => $this->request->getPost('instruksi'),
            'tipe'          => $this->request->getPost('tipe'),
            'tanggal_dibuat'=> date('Y-m-d H:i:s')
        ]);

        $kegiatanId = $this->kegiatanModel->getInsertID();

        $deskripsi = $this->request->getPost('deskripsi');
        $poin = $this->request->getPost('poin');

        if ($deskripsi) {
            foreach ($deskripsi as $key => $val) {
                if (!empty($val)) {
                    $this->kriteriaModel->save([
                        'kegiatan_id' => $kegiatanId,
                        'deskripsi'   => $val,
                        'poin'        => $poin[$key]
                    ]);
                }
            }
        }

        return redirect()->to('/walas/kegiatan')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guruId = $this->getGuruId();
        $kegiatan = $this->kegiatanModel->find($id);

        if (!$kegiatan || $kegiatan['wali_kelas_id'] != $guruId) {
            return redirect()->to('/walas/kegiatan')->with('error', 'Kegiatan tidak ditemukan atau akses ditolak.');
        }

        $data = [
            'title'    => 'Edit Kegiatan',
            'kegiatan' => $kegiatan,
            'kriteria' => $this->kriteriaModel->where('kegiatan_id', $id)->findAll()
        ];

        return view('walas/kegiatan/form', $data);
    }

    public function update($id)
    {
        $guruId = $this->getGuruId();
        $kegiatan = $this->kegiatanModel->find($id);

        if (!$kegiatan || $kegiatan['wali_kelas_id'] != $guruId) {
            return redirect()->to('/walas/kegiatan')->with('error', 'Akses ditolak.');
        }

        if (!$this->validate([
            'judul'       => 'required',
            'instruksi'   => 'required',
            'tipe'        => 'required|in_list[harian,sekali]',
            'deskripsi.*' => 'required',
            'poin.*'      => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kegiatanModel->update($id, [
            'judul'     => $this->request->getPost('judul'),
            'instruksi' => $this->request->getPost('instruksi'),
            'tipe'      => $this->request->getPost('tipe')
        ]);

        $this->kriteriaModel->where('kegiatan_id', $id)->delete();

        $deskripsi = $this->request->getPost('deskripsi');
        $poin = $this->request->getPost('poin');

        if ($deskripsi) {
            foreach ($deskripsi as $key => $val) {
                if (!empty($val)) {
                    $this->kriteriaModel->save([
                        'kegiatan_id' => $id,
                        'deskripsi'   => $val,
                        'poin'        => $poin[$key]
                    ]);
                }
            }
        }

        return redirect()->to('/walas/kegiatan')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $guruId = $this->getGuruId();
        $kegiatan = $this->kegiatanModel->find($id);

        if ($kegiatan && $kegiatan['wali_kelas_id'] == $guruId) {
            $this->kegiatanModel->delete($id);
            return redirect()->to('/walas/kegiatan')->with('success', 'Kegiatan berhasil dihapus.');
        }

        return redirect()->to('/walas/kegiatan')->with('error', 'Gagal menghapus kegiatan.');
    }
}