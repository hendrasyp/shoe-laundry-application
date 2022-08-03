<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends MX_Controller {

    private $view;
    private $userInfo;
    private $pageUrl;

    public function __construct() {
        parent::__construct();
        $this->data['page_title'] = 'Company Management';
        $this->userInfo = $this->userInfo()["user"];
        $this->load->model('Mcounter');
        $this->data['pageurl'] = 'administration/company';
        $this->pageUrl = $this->data['pageurl'];
    }

    private function customer_header($sheet) {
        $header = array("No", 
          "Nama Customer", 
          "No Telepon", 
          "Email", 
          "Counter Origin", "Tanggal Terdaftar", 'Jumlah Poin Aktif', 'Total Point');
        
        $sheet->setCellValue('A1', $header[0]);
        $sheet->setCellValue('B1', $header[1]);
        $sheet->setCellValue('C1', $header[2]);
        $sheet->setCellValue('D1', $header[3]);
        $sheet->setCellValue('E1', $header[4]);
        $sheet->setCellValue('F1', $header[5]);
        $sheet->setCellValue('G1', $header[6]);
        $sheet->setCellValue('H1', $header[7]);
    }

    public function customer() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $data = $this
            ->common_model
            ->condition(array('counterid' => $this->userInfo->counterid))
            ->table_name(V_USER_LIST)
            ->do_read();
        $this->customer_header($sheet);
        $no = 1;
        $row = 2;

        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $value->name);
            $sheet->setCellValue('C' . $row, $value->phone);
            $sheet->setCellValue('D' . $row, $value->email);
            $sheet->setCellValue('E' . $row, $value->counter);
            $sheet->setCellValue('F' . $row, "");
            $sheet->setCellValue('G' . $row, "");
            $sheet->setCellValue('H' . $row, "");
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = strtolower(FILENAME_CUSTOMER_LIST . $this->userInfo->counter);

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . strtolower($filename) . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
