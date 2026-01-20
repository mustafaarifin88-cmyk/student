<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\UserModel;
use App\Models\KelasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class Guru extends BaseController
{
    protected $guruModel;
    protected $userModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->userModel = new UserModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Guru',
            'guru'  => $this->guruModel->getGuruLengkap()
        ];
        return view('admin/guru/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Guru',
            'kelas' => $this->kelasModel->findAll()
        ];
        return view('admin/guru/form', $data);
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
            'role'         => 'walas',
            'foto'         => $namaFoto
        ]);

        $userId = $this->userModel->getInsertID();

        $this->guruModel->save([
            'user_id' => $userId,
            'nip'     => $this->request->getPost('nip')
        ]);

        $guruId = $this->guruModel->getInsertID();
        $kelasId = $this->request->getPost('kelas_id');

        if (!empty($kelasId)) {
            $this->kelasModel->update($kelasId, ['wali_kelas_id' => $guruId]);
        }

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = $this->guruModel->getGuruLengkap($id);
        
        $kelasCurrent = $this->kelasModel->where('wali_kelas_id', $id)->first();

        $data = [
            'title'         => 'Edit Guru',
            'guru'          => $guru,
            'kelas'         => $this->kelasModel->findAll(),
            'kelas_current' => $kelasCurrent ? $kelasCurrent['id'] : null
        ];
        return view('admin/guru/form', $data);
    }

    public function update($id)
    {
        $guru = $this->guruModel->find($id);
        $user = $this->userModel->find($guru['user_id']);

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

        $this->userModel->update($guru['user_id'], $userData);

        $this->guruModel->update($id, [
            'nip' => $this->request->getPost('nip')
        ]);

        $this->kelasModel->where('wali_kelas_id', $id)->set(['wali_kelas_id' => null])->update();
        
        $kelasId = $this->request->getPost('kelas_id');
        if (!empty($kelasId)) {
            $this->kelasModel->update($kelasId, ['wali_kelas_id' => $id]);
        }

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function delete($id)
    {
        $guru = $this->guruModel->find($id);
        if ($guru) {
            $user = $this->userModel->find($guru['user_id']);
            
            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }

            $this->userModel->delete($guru['user_id']); 
        }
        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NIP');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Password');
        $sheet->setCellValue('E1', 'Kelas (Opsional)');

        $kelasData = $this->kelasModel->findAll();
        $kelasNames = [];
        foreach ($kelasData as $k) {
            $kelasNames[] = $k['nama_kelas'];
        }

        if (!empty($kelasNames)) {
            $validation = $sheet->getCell('E2')->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"' . implode(',', $kelasNames) . '"');

            for ($i = 3; $i <= 100; $i++) {
                $sheet->getCell('E' . $i)->setDataValidation(clone $validation);
            }
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'template_guru.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit();
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');

        if ($file) {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            foreach ($rows as $key => $row) {
                if ($key == 0) continue; 
                
                $nip = $row[0];
                $nama = $row[1];
                $username = $row[2];
                $password = $row[3];
                $namaKelas = $row[4];

                if ($nama && $username && $password) {
                    $exists = $this->userModel->where('username', $username)->first();
                    if (!$exists) {
                        $this->userModel->save([
                            'nama_lengkap' => $nama,
                            'username'     => $username,
                            'password'     => password_hash($password, PASSWORD_BCRYPT),
                            'role'         => 'walas',
                            'foto'         => 'default.png'
                        ]);
                        $userId = $this->userModel->getInsertID();

                        $this->guruModel->save([
                            'user_id' => $userId,
                            'nip'     => $nip
                        ]);
                        $guruId = $this->guruModel->getInsertID();

                        if ($namaKelas) {
                            $kelas = $this->kelasModel->where('nama_kelas', $namaKelas)->first();
                            if ($kelas) {
                                $this->kelasModel->update($kelas['id'], ['wali_kelas_id' => $guruId]);
                            }
                        }
                    }
                }
            }
            return redirect()->to('/admin/guru')->with('success', 'Import data guru berhasil.');
        }
        return redirect()->to('/admin/guru')->with('error', 'Gagal mengupload file.');
    }
}