<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author Kesav
 */
class Merchants extends My_Controller {

    private $view_dir;

    //put your code here
    public function __construct() {
        parent::__construct();
        if ($this->router->fetch_method() != 'index') {
            /* if (!$this->_is_logged_in()) {
              redirect(base_url() . "Admin");
              } */
        }
        $this->view_dir = 'admin/' . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('admin_main.php');
    }

    /* public function index(){
      // Add user data in session
      $data=array();
      $this->layout->setLayout('admin_main.php');
      $this->layout->view($this->view_dir, $data);
      } */

    public function index() {

        $this->load->library('excel');
        $inputFileType = PHPExcel_IOFactory::identify(FCPATH . 'merchant_upload/rest_au.xlsx');

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        $objReader->setReadDataOnly(true);

        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load(FCPATH . 'merchant_upload/rest_au.xlsx');

        $total_sheets = $objPHPExcel->getSheetCount();

        $allSheetName = $objPHPExcel->getSheetNames();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        for ($row = 1; $row <= $highestRow; ++$row) {
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

                $arraydata[$row - 1][$col] = $value;
            }
        }

        echo '<pre>';

        print_r($arraydata);
        exit;
////activate worksheet number 1
//        $this->excel->setActiveSheetIndex(0);
////name the worksheet
//        $this->excel->getActiveSheet()->setTitle('test worksheet');
////set cell A1 content with some text
//        $this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
////change the font size
//        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
////make the font become bold
//        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
////merge cell A1 until D1
//        $this->excel->getActiveSheet()->mergeCells('A1:D1');
////set aligment to center for that merged cell (A1 to D1)
//        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//
//        $filename = 'just_some_random_name.xls'; //save our workbook as this file name
//        header('Content-Type: application/vnd.ms-excel'); //mime type
//        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
//        header('Cache-Control: max-age=0'); //no cache
////save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
////if you want to save it as .XLSX Excel 2007 format
//        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
////force user to download the Excel file without writing it to server's HD
//        $objWriter->save('php://output'); exit;
        $data = array();

        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U', 'merchant as ME');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id_merchant = ME.user_id');
        $data['reviews'] = $this->common_model->get_records(0, 'OFR.id_customer,OFR.id_merchant,OFR.review,OFR.status,OFR.id,U.firstname,ME.business_name', '');

        $this->layout->view($this->view_dir, $data);
    }

}
