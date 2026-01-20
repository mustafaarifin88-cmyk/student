<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    protected $logModel;
    protected $siswaModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel();
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to('/auth/logout');
        }

        $logs = $this->logModel->getLogsBySiswa($siswa['id']);
        
        $data = [
            'title' => 'Laporan Aktivitas Saya',
            'logs'  => $logs,
            'siswa' => $siswa
        ];

        return view('siswa/laporan/index', $data);
    }

    public function cetakPDF()
    {
        $userId = session()->get('id');
        $siswaRaw = $this->siswaModel->where('user_id', $userId)->first();
        
        if (!$siswaRaw) {
            return redirect()->to('/auth/logout');
        }
        
        $siswaLengkap = $this->siswaModel->getSiswaLengkap($siswaRaw['id']);
        $logs = $this->logModel->getLogsBySiswa($siswaRaw['id']);

        $dompdf = new Dompdf();
        
        $html = view('siswa/laporan/cetak_pdf', [
            'siswa' => $siswaLengkap,
            'logs' => $logs,
            'title' => 'Laporan Aktivitas Siswa'
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_Aktivitas_' . $siswaLengkap['nama_lengkap'] . '.pdf', ["Attachment" => true]);
    }

    public function cetakExcel()
    {
        $userId = session()->get('id');
        $siswaRaw = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswaRaw) {
            return redirect()->to('/auth/logout');
        }

        $siswaLengkap = $this->siswaModel->getSiswaLengkap($siswaRaw['id']);
        $logs = $this->logModel->getLogsBySiswa($siswaRaw['id']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Aktivitas Siswa');
        $sheet->setCellValue('A2', 'Nama: ' . $siswaLengkap['nama_lengkap']);
        $sheet->setCellValue('A3', 'Kelas: ' . $siswaLengkap['nama_kelas']);
        $sheet->setCellValue('A4', 'NISN: ' . $siswaLengkap['nisn']);

        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Tanggal');
        $sheet->setCellValue('C6', 'Kegiatan');
        $sheet->setCellValue('D6', 'Poin Diperoleh');

        $row = 7;
        $no = 1;
        foreach ($logs as $log) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, date('d-m-Y H:i', strtotime($log['tanggal_dikerjakan'])));
            $sheet->setCellValue('C' . $row, $log['judul']);
            $sheet->setCellValue('D' . $row, $log['total_poin_diperoleh']);
            $row++;
        }

        $sheet->setCellValue('C' . $row, 'Total Poin Saat Ini');
        $sheet->setCellValue('D' . $row, $siswaLengkap['total_poin']);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Aktivitas_' . preg_replace('/[^A-Za-z0-9]/', '_', $siswaLengkap['nama_lengkap']) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}