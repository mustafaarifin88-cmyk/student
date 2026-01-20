<?php

namespace App\Controllers\Walas;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $userModel;
    protected $guruModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
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

    public function index()
    {
        $kelasId = $this->getKelasId();

        if (!$kelasId) {
            return view('walas/siswa/index', [
                'title' => 'Data Siswa',
                'siswa' => [],
                'error' => 'Anda belum ditugaskan sebagai wali kelas.'
            ]);
        }

        $data = [
            'title' => 'Data Siswa Kelas Saya',
            'siswa' => $this->siswaModel->getSiswaByKelas($kelasId)
        ];
        return view('walas/siswa/index', $data);
    }

    public function store()
    {
        $kelasId = $this->getKelasId();
        if (!$kelasId) {
            return redirect()->back()->with('error', 'Akses ditolak. Anda tidak memiliki kelas.');
        }

        $rules = [
            'nama_lengkap' => 'required',
            'username'     => 'required|is_unique[users.username]',
            'password'     => 'required|min_length[6]',
            'foto'         => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = 'default.png';

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(UPLOAD_PATH_PROFIL, $namaFoto);
        }

        $this->userModel->save([
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'         => 'siswa',
            'foto'         => $namaFoto
        ]);

        $userId = $this->userModel->getInsertID();

        $this->siswaModel->save([
            'user_id'  => $userId,
            'nisn'     => $this->request->getPost('nisn'),
            'kelas_id' => $kelasId,
            'total_poin' => 0
        ]);

        return redirect()->to('/walas/siswa')->with('success', 'Siswa berhasil ditambahkan ke kelas Anda.');
    }

    public function update($id)
    {
        $siswa = $this->siswaModel->find($id);
        
        $kelasId = $this->getKelasId();
        if (!$siswa || $siswa['kelas_id'] != $kelasId) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan di kelas Anda.');
        }

        $user = $this->userModel->find($siswa['user_id']);

        $rules = [
            'nama_lengkap' => 'required',
            'username'     => 'required',
            'foto'         => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if ($user['username'] != $this->request->getPost('username')) {
            $rules['username'] .= '|is_unique[users.username]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(UPLOAD_PATH_PROFIL, $namaFoto);
            $userData['foto'] = $namaFoto;

            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }
        }

        $this->userModel->update($siswa['user_id'], $userData);

        $this->siswaModel->update($id, [
            'nisn' => $this->request->getPost('nisn')
        ]);

        return redirect()->to('/walas/siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        $kelasId = $this->getKelasId();

        if ($siswa && $siswa['kelas_id'] == $kelasId) {
            $user = $this->userModel->find($siswa['user_id']);
            
            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }

            $this->userModel->delete($siswa['user_id']); 
            return redirect()->to('/walas/siswa')->with('success', 'Siswa berhasil dihapus dari kelas.');
        }

        return redirect()->to('/walas/siswa')->with('error', 'Gagal menghapus siswa.');
    }
}