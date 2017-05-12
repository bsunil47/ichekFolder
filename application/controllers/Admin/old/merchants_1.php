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

    public function upload_excel() {
        // Add merchants from excel sheet
        $data = array();
        $msc = microtime(true);

        if (isset($_POST['submit'])) {
            if (is_uploaded_file($_FILES['excel_file']['tmp_name'])) {
                if ($_FILES['excel_file']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['excel_file']['type'] == 'application/vnd.ms-excel') {

                    move_uploaded_file($_FILES['excel_file']['tmp_name'], 'merchant_upload/' . date('dmYHis') . '_' . $_FILES['excel_file']['name']);

                    $this->load->library('excel');
                    $inputFileType = PHPExcel_IOFactory::identify(FCPATH . 'merchant_upload/' . date('dmYHis') . '_' . $_FILES['excel_file']['name']);

                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);

                    $objReader->setReadDataOnly(true);

                    /**  Load $inputFileName to a PHPExcel Object  * */
                    $objPHPExcel = $objReader->load(FCPATH . 'merchant_upload/' . date('dmYHis') . '_' . $_FILES['excel_file']['name']);

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
                    $field_array = array('business_name', 'address', 'city', 'state', 'pincode', 'cross_street', 'phone', 'rating', 'reviews',
                        'url', 'price_range', 'hours', 'reservations', 'delevery', 'takeout', 'accept_credit_cards', 'good_for', 'parking', 'wheelchair_accesable',
                        'good_for_kids', 'good_for_groups', 'attire', 'ambience', 'noise_level', 'music', 'dancing', 'serves_alcohol', 'happy_hour', 'best_nights',
                        'coat_check', 'smoking_allowed', 'outdoor_seating', 'wifi', 'tv', 'allows_dogs', 'waiter_service', 'caters', 'by_appoinment_only', 'category',
                        'lat', 'long', 'business_logo_url');
                    echo '<pre>';

                    $basic_array = array();
                    $details_array = array();

                    $this->common_model->initialise('business');
                    $res = $this->common_model->get_record_single('id != 0 order by id desc', "user_id");
                    ($res) ? $user_id = ($res->user_id) + 1 : $user_id = 1;

                    foreach ($arraydata as $keys => $values) {
                        if ($keys != 0) {

                            $this->common_model->initialise('business');
                            $row = $this->common_model->get_record_single(array('business_name' => $arraydata[$keys][0], 'phone' => $arraydata[$keys][6]), "COUNT(*) as count");

                            if ($row->count == 0) {

                                foreach ($values as $key => $value) {

                                    if ($key < 42) {

                                        if ($key == 0 || $key == 1 || $key == 2 || $key == 3 || $key == 4 || $key == 6 || $key == 9 || $key == 39 || $key == 40 || $key == 41) {
                                            $basic_array[$keys][$field_array[$key]] = $value;
                                            $basic_array[$keys]['user_id'] = $user_id;
                                        } else {
                                            $details_array[$keys][$field_array[$key]] = $value;
                                            $details_array[$keys]['user_id'] = $user_id;
                                        }
                                    }//no.ofcolumns
                                }//foreach
                                $user_id++;
                            }//!duplicates
                        }//!firstrow
                    }//foreach
                    //print_r($basic_array);exit;

                    if (count($basic_array) != 0) {
                        //insert into tbl_merchant_excel
                        $this->common_model->initialise('business');
                        $this->array = $basic_array;
                        $ins1 = $this->common_model->insert_batch_entry();
                        if ($ins1) {
                            $data['result'] = "merchants added succesfully";
                        }
                    }

                    if (count($details_array) != 0) {
                        //insert into tbl_merchantdetails
                        $this->common_model->initialise('businessdetails');
                        $this->array = $details_array;
                        $ins2 = $this->common_model->insert_batch_entry();
                        if ($ins2) {
                            //$data['result'] = "merchants added succesfully";
                        }
                    }
                }//file-type
            }//uploaded-file
            redirect(base_url() . "Admin/merchants/upload_excel");
        }//submit
        //$this->layout->setLayout('admin_main.php');
        $data['menuid'] = 'addmerchant';
        $this->layout->view($this->view_dir, $data);
    }

    //redirect(base_url() . "Admin/merchants/upload_excel.php");
}

//class
