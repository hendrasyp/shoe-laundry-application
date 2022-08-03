<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Welcome extends CI_Controller {

    public function index() {
        $this->load->view('welcome_message');
    }

    public function generatePDF() {
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('welcome_message', array('user' => "suhe tampan"), true);
        $mpdf->WriteHTML($html);
        $mpdf->Output(); // opens in browser
        //$mpdf->Output('invoice.pdf','D'); // it will work as normal download
    }

    public function generateXLS() {
        //$this->load->model('siswa_model');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Kelas');
        $sheet->setCellValue('D1', 'Jenis Kelamin');
        $sheet->setCellValue('E1', 'Alamat');

        //$siswa = $this->siswa_model->getAll();
        $no = 1;
        $x = 2;
//        foreach ($siswa as $row) {
//            $sheet->setCellValue('A' . $x, $no++);
//            $sheet->setCellValue('B' . $x, $row->nama);
//            $sheet->setCellValue('C' . $x, $row->kelas);
//            $sheet->setCellValue('D' . $x, $row->jenis_kelamin);
//            $sheet->setCellValue('E' . $x, $row->alamat);
//            $x++;
//        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-siswa';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

?>