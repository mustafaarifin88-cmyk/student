<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\GuruModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $guruModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kelas',
            'kelas' => $this->kelasModel->select('kelas.*, users.nama_lengkap as nama_walas')
                                      ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
                                      ->join('users', 'users.id = guru.user_id', 'left')
                                      ->findAll()
        ];
        return view('admin/kelas/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kelas',
            'guru'  => $this->guruModel->getGuruLengkap()
        ];
        return view('admin/kelas/form', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama_kelas' => 'required|is_unique[kelas.nama_kelas]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->save([
            'nama_kelas' => $this->request->getVar('nama_kelas'),
            'wali_kelas_id' => $this->request->getVar('wali_kelas_id') ?: null
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $this->kelasModel->find($id),
            'guru'  => $this->guruModel->getGuruLengkap()
        ];
        return view('admin/kelas/form', $data);
    }

    public function update($id)
    {
        $kelasLama = $this->kelasModel->find($id);
        if ($kelasLama['nama_kelas'] == $this->request->getVar('nama_kelas')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[kelas.nama_kelas]';
        }

        if (!$this->validate([
            'nama_kelas' => $rule_nama
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getVar('nama_kelas'),
            'wali_kelas_id' => $this->request->getVar('wali_kelas_id') ?: null
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Kelas');
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'template_kelas.xlsx';
        
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
                
                $namaKelas = $row[1];

                if ($namaKelas) {
                    $exists = $this->kelasModel->where('nama_kelas', $namaKelas)->first();
                    if (!$exists) {
                        $this->kelasModel->save([
                            'nama_kelas' => $namaKelas
                        ]);
                    }
                }
            }
            return redirect()->to('/admin/kelas')->with('success', 'Import data kelas berhasil.');
        }
        return redirect()->to('/admin/kelas')->with('error', 'Gagal mengupload file.');
    }
}