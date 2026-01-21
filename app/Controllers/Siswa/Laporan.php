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

    private function getFilterDates($waktu)
    {
        $startDate = null;
        $endDate = date('Y-m-d');

        if ($waktu) {
            switch ($waktu) {
                case '1_minggu':
                    $startDate = date('Y-m-d', strtotime('-1 week'));
                    break;
                case '1_bulan':
                    $startDate = date('Y-m-d', strtotime('-1 month'));
                    break;
                case '1_tahun':
                    $startDate = date('Y-m-d', strtotime('-1 year'));
                    break;
            }
        }
        return ['start' => $startDate, 'end' => $endDate];
    }

    public function index()
    {
        $userId = session()->get('id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to('/auth/logout');
        }

        $waktu = $this->request->getVar('waktu');
        $dates = $this->getFilterDates($waktu);

        $logs = $this->logModel->getLogsBySiswa($siswa['id'], $dates['start'], $dates['end']);
        
        $data = [
            'title' => 'Laporan Aktivitas Saya',
            'logs'  => $logs,
            'siswa' => $siswa,
            'selected_waktu' => $waktu 
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
        
        $waktu = $this->request->getGet('waktu');
        $dates = $this->getFilterDates($waktu);
        
        $logs = $this->logModel->getLogsBySiswa($siswaRaw['id'], $dates['start'], $dates['end']);

        $dompdf = new Dompdf();
        
        $titleSuffix = $waktu ? ' (' . str_replace('_', ' ', $waktu) . ')' : '';

        $html = view('siswa/laporan/cetak_pdf', [
            'siswa' => $siswaLengkap,
            'logs' => $logs,
            'title' => 'Laporan Aktivitas Siswa' . $titleSuffix
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
        
        $waktu = $this->request->getGet('waktu');
        $dates = $this->getFilterDates($waktu);

        $logs = $this->logModel->getLogsBySiswa($siswaRaw['id'], $dates['start'], $dates['end']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Aktivitas Siswa');
        $sheet->setCellValue('A2', 'Nama: ' . $siswaLengkap['nama_lengkap']);
        $sheet->setCellValue('A3', 'Kelas: ' . $siswaLengkap['nama_kelas']);
        $sheet->setCellValue('A4', 'NISN: ' . $siswaLengkap['nisn']);
        
        if($waktu) {
            $sheet->setCellValue('A5', 'Periode: ' . ucwords(str_replace('_', ' ', $waktu)));
        }

        $sheet->setCellValue('A7', 'No');
        $sheet->setCellValue('B7', 'Tanggal');
        $sheet->setCellValue('C7', 'Kegiatan');
        $sheet->setCellValue('D7', 'Poin Diperoleh');

        $row = 8;
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