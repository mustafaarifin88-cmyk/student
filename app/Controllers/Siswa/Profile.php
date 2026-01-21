<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $id = session()->get('id');
        
        $data = [
            'title' => 'Edit Profil Saya',
            'user'  => $userModel->find($id)
        ];

        return view('siswa/profile/index', $data);
    }

    public function update()
    {
        $userModel = new UserModel();
        $id = session()->get('id');
        $user = $userModel->find($id);

        $rules = [
            'foto' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [];

        // Update Password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            if (strlen($password) < 6) {
                return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
            }
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Update Foto jika ada file
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $newName = $fileFoto->getRandomName();
            $fileFoto->move(UPLOAD_PATH_PROFIL, $newName);
            
            $data['foto'] = $newName;

            // Hapus foto lama jika bukan default
            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }

            // Update session foto agar langsung berubah di navbar
            session()->set('foto', $newName);
        }

        if (empty($data)) {
            return redirect()->to('/siswa/profile')->with('info', 'Tidak ada perubahan yang disimpan.');
        }

        $userModel->update($id, $data);

        return redirect()->to('/siswa/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}