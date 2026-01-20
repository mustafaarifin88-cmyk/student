<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $id = session()->get('id');
        $data = [
            'title' => 'Edit Profil',
            'user'  => $userModel->find($id)
        ];

        return view('admin/profile/index', $data);
    }

    public function update()
    {
        $userModel = new UserModel();
        $id = session()->get('id');
        $user = $userModel->find($id);

        $rules = [
            'nama_lengkap' => 'required',
            'username'     => 'required',
            'foto'         => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if ($this->request->getPost('username') != $user['username']) {
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
            $newName = $fileFoto->getRandomName();
            $fileFoto->move(UPLOAD_PATH_PROFIL, $newName);
            $data['foto'] = $newName;

            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }

            session()->set('foto', $newName);
        }

        session()->set('nama_lengkap', $data['nama_lengkap']);
        session()->set('username', $data['username']);

        $userModel->update($id, $data);

        return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}