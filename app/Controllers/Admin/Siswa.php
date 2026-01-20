<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\KelasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $userModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Siswa',
            'siswa' => $this->siswaModel->getSiswaLengkap()
        ];
        return view('admin/siswa/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'kelas' => $this->kelasModel->findAll()
        ];
        return view('admin/siswa/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama_lengkap' => 'required',
            'username'     => 'required|is_unique[users.username]',
            'password'     => 'required|min_length[6]',
            'kelas_id'     => 'required',
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
            'kelas_id' => $this->request->getPost('kelas_id'),
            'total_poin' => 0
        ]);

        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = $this->siswaModel->getSiswaLengkap($id);
        
        $data = [
            'title' => 'Edit Siswa',
            'siswa' => $siswa,
            'kelas' => $this->kelasModel->findAll()
        ];
        return view('admin/siswa/form', $data);
    }

    public function update($id)
    {
        $siswa = $this->siswaModel->find($id);
        $user = $this->userModel->find($siswa['user_id']);

        $rules = [
            'nama_lengkap' => 'required',
            'username'     => 'required',
            'kelas_id'     => 'required',
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
            'nisn'     => $this->request->getPost('nisn'),
            'kelas_id' => $this->request->getPost('kelas_id')
        ]);

        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        if ($siswa) {
            $user = $this->userModel->find($siswa['user_id']);
            
            if ($user['foto'] != 'default.png' && file_exists(UPLOAD_PATH_PROFIL . $user['foto'])) {
                unlink(UPLOAD_PATH_PROFIL . $user['foto']);
            }

            $this->userModel->delete($siswa['user_id']); 
        }
        return redirect()->to('/admin/siswa')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NISN');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Password');
        $sheet->setCellValue('E1', 'Kelas');

        $kelasData = $this->kelasModel->findAll();
        $kelasNames = [];
        foreach ($kelasData as $k) {
            $kelasNames[] = $k['nama_kelas'];
        }

        if (!empty($kelasNames)) {
            $validation = $sheet->getCell('E2')->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"' . implode(',', $kelasNames) . '"');

            for ($i = 3; $i <= 100; $i++) {
                $sheet->getCell('E' . $i)->setDataValidation(clone $validation);
            }
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'template_siswa.xlsx';
        
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
                
                $nisn = $row[0];
                $nama = $row[1];
                $username = $row[2];
                $password = $row[3];
                $namaKelas = $row[4];

                if ($nama && $username && $password && $namaKelas) {
                    $exists = $this->userModel->where('username', $username)->first();
                    if (!$exists) {
                        $kelas = $this->kelasModel->where('nama_kelas', $namaKelas)->first();
                        
                        if ($kelas) {
                            $this->userModel->save([
                                'nama_lengkap' => $nama,
                                'username'     => $username,
                                'password'     => password_hash($password, PASSWORD_BCRYPT),
                                'role'         => 'siswa',
                                'foto'         => 'default.png'
                            ]);
                            $userId = $this->userModel->getInsertID();

                            $this->siswaModel->save([
                                'user_id'  => $userId,
                                'nisn'     => $nisn,
                                'kelas_id' => $kelas['id'],
                                'total_poin' => 0
                            ]);
                        }
                    }
                }
            }
            return redirect()->to('/admin/siswa')->with('success', 'Import data siswa berhasil.');
        }
        return redirect()->to('/admin/siswa')->with('error', 'Gagal mengupload file.');
    }
}