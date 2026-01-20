<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Admin',
            'users' => $this->userModel->where('role', 'admin')->findAll()
        ];
        return view('admin/user/index', $data);
    }

    public function store()
    {
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
            'role'         => 'admin',
            'foto'         => $namaFoto
        ]);

        return redirect()->to('/admin/user')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

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

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(UPLOAD_PATH_PROFIL, $namaFoto);
            $data['foto'] = $namaFoto;

            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/user')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if ($user) {
            $admins = $this->userModel->where('role', 'admin')->countAllResults();
            if ($admins <= 1) {
                return redirect()->to('/admin/user')->with('error', 'Tidak dapat menghapus admin terakhir.');
            }

            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }

            $this->userModel->delete($id);
        }

        return redirect()->to('/admin/user')->with('success', 'Admin berhasil dihapus.');
    }
}