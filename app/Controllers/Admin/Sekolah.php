<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;

class Sekolah extends BaseController
{
    public function index()
    {
        $model = new SekolahModel();
        $data = [
            'title'   => 'Profil Sekolah',
            'sekolah' => $model->first()
        ];

        return view('admin/sekolah/index', $data);
    }

    public function update()
    {
        $model = new SekolahModel();
        $id = $this->request->getPost('id');
        $sekolah = $model->find($id);

        $rules = [
            'nama_sekolah' => 'required',
            'alamat'       => 'required',
            'logo'         => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'alamat'       => $this->request->getPost('alamat'),
        ];

        $fileLogo = $this->request->getFile('logo');

        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $newName = $fileLogo->getRandomName();
            $fileLogo->move(UPLOAD_PATH_SEKOLAH, $newName);
            
            $data['logo'] = $newName;

            if ($sekolah && $sekolah['logo'] != 'default_logo.png' && file_exists(UPLOAD_PATH_SEKOLAH . $sekolah['logo'])) {
                unlink(UPLOAD_PATH_SEKOLAH . $sekolah['logo']);
            }
        }

        if ($sekolah) {
            $model->update($id, $data);
        } else {
            if (!isset($data['logo'])) {
                $data['logo'] = 'default_logo.png';
            }
            $model->insert($data);
        }

        return redirect()->to('/admin/sekolah')->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}