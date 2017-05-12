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
class Merchants_1 extends My_Controller {

    private $view_dir;

//put your code here
    public function __construct() {
        parent::__construct();
        $this->admin_base_url = base_url() . 'Admin/' . $this->router->fetch_class();
        if ($this->router->fetch_method() != 'index') {
            /* if (!$this->_is_logged_in()) {
              redirect(base_url() . "Admin");
              } */
        }
        $this->view_dir = 'admin/' . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('admin_main.php');
    }

    public function index() {

// Add user data in session
        $data = array();
        $data['menuid'] = 'merchantslistn';

        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function upload_excel() {
// Add merchants from excel sheet
        $data = array();
        $msc = microtime(true);
        ini_set("max_execution_time", '5000');
        ini_set('memory_limit', '2000M');
        if (isset($_POST['submit'])) {
            if (is_uploaded_file($_FILES['excel_file']['tmp_name'])) {
                if ($_FILES['excel_file']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['excel_file']['type'] == 'application/vnd.ms-excel') {
                    $uniqid = date('dmYHis');
                    $basic_array = array();
                    if (move_uploaded_file($_FILES['excel_file']['tmp_name'], 'merchant_upload/' . $uniqid . '_' . $_FILES['excel_file']['name'])) {
                        $this->load->library('excel');
                        $inputFileType = PHPExcel_IOFactory::identify(FCPATH . 'merchant_upload/' . $uniqid . '_' . $_FILES['excel_file']['name']);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objReader->setReadDataOnly(true);
                        /**  Load $inputFileName to a PHPExcel Object  * */
                        $objPHPExcel = $objReader->load(FCPATH . 'merchant_upload/' . $uniqid . '_' . $_FILES['excel_file']['name']);
                        $total_sheets = $objPHPExcel->getSheetCount();
                        $allSheetName = $objPHPExcel->getSheetNames();
                        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                        $highestRow = $objWorksheet->getHighestRow();
                        $highestColumn = $objWorksheet->getHighestColumn();
                        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
//                        $highestColumnIndex = 42;
                        for ($row = 1; $row <= $highestRow; ++$row) {
                            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                                $arraydata[$row - 1][$col] = $value;
                            }
                        }
                        echo "Memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . "</br>";
                        echo '<pre>';
                        $field_array = array('business_name', 'address', 'city', 'state', 'pincode', 'cross_street', 'phone', 'rating', 'url', 'price_range', 'hours', 'reservations', 'delevery', 'takeout', 'accept_credit_cards', 'good_for', 'parking', 'wheelchair_accesable',
                            'good_for_kids', 'good_for_groups', 'attire', 'ambience', 'noise_level', 'music', 'dancing', 'serves_alcohol', 'happy_hour', 'best_nights',
                            'coat_check', 'smoking_allowed', 'outdoor_seating', 'wifi', 'tv', 'allows_dogs', 'waiter_service', 'caters', 'by_appoinment_only', 'category',
                            'lat', 'lng', 'listing_url', 'merchant_verify', 'email');
//                        $field_array = array('business_name', 'address', 'city', 'state', 'pincode', 'cross_street', 'phone', 'rating', 'reviews',
//                            'url', 'price_range', 'hours', 'reservations', 'delevery', 'takeout', 'accept_credit_cards', 'good_for', 'parking', 'wheelchair_accesable',
//                            'good_for_kids', 'good_for_groups', 'attire', 'ambience', 'noise_level', 'music', 'dancing', 'serves_alcohol', 'happy_hour', 'best_nights',
//                            'coat_check', 'smoking_allowed', 'outdoor_seating', 'wifi', 'tv', 'allows_dogs', 'waiter_service', 'caters', 'by_appoinment_only', 'category',
//                            'lat', 'lng', 'business_logo_url');
                        foreach ($arraydata as $keys => $values) {
                            if ($keys != 0) {

                                $this->common_model->initialise('businesscore');
                                $row = $this->common_model->get_record_single(array('business_name' => $arraydata[$keys][0], 'phone' => $arraydata[$keys][6]), "COUNT(*) as count");

                                if ($row->count == 0) {

                                    foreach ($values as $key => $value) {

                                        if ($key < 44) {

                                            $basic_array[$keys][$field_array[$key]] = $value;
//print_r($basic_array);
                                        } else {
                                            break; //no.ofcolumns
                                        }
                                    }//foreach
//print_r($basic_array);
                                }//!duplicates
                            }//!firstrow
                            if ($highestRow < $keys) {
                                break;
                            }
                        }//foreach
                        if (count($basic_array) != 0) {
//insert into tbl_merchant_excel
                            $this->common_model->initialise('businesscore');
                            $this->array = $basic_array;
                            $ins1 = $this->common_model->insert_batch_entry();
                            if ($ins1) {
                                $data['result'] = "merchants added succesfully";
                            } else {
                                $data['result'] = "Please try again";
                            }
                        } else {
                            $data['result'] = "Merchants already existed";
                        }
                    } else {
                        echo 'Problem with file upload';
                    }
                }//file-type
            }//uploaded-file
            redirect(base_url() . "Admin/merchants_1/upload_excel");
        }//submit
//$this->layout->setLayout('admin_main.php');
        $data['menuid'] = 'addmerchant';
        $this->layout->view($this->view_dir, $data);
    }

    public function view($id) {
        $data = array();
        $this->common_model->initialise('businesscore');
        $data['merchantsuploadlist'] = $this->common_model->get_record_single(array('id' => $id), '*');
        $data['menuid'] = 'merchantslistn';
        $this->layout->view($this->view_dir, $data);
    }

    public function getData() {
        $aColumns = array('id', 'business_name', 'category', 'address', 'phone');
        $this->common_model->initialise('businesscore');
        $data = $this->common_model->getTable($aColumns);
        $output = $data['output'];
//print_r($output);
        foreach ($data['result'] as $aRow) {
            $row = array();

            foreach ($aColumns as $col) {
                $row[] = $aRow[$col];
            }
            $row[] = '<a href="' . base_url() . 'Admin/merchants_1/view/' . $aRow['id'] . '"><button class="btn" title="View" style="border:1px solid #cccccc;">View</button></a>';
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    public function invitebusiness() {

        $data = array();
        $this->common_model->initialise('invitebusiness as IB');
        $this->common_model->join_tables = array('users as U', 'business as B');
        $this->common_model->join_on = array('IB.user_id = U.id', 'IB.business_id = B.id');
        $where = 0;
        $data['invitebusiness'] = $this->common_model->get_records(0, '*', $where);
        $data['menuid'] = 'invitebusiness';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getInvited() {

//        $aColumns = array('business_invite_id', 'firstname', 'business_name', 'phone', 'B.email', 'category');
//        $this->common_model->initialise('invitebusiness as I');
//        $this->common_model->join_tables = array('users as U', 'business as B');
//        $this->common_model->join_on = array('I.user_id = U.id', 'I.business_id = B.id');
//        $where = 0;
//        $data = $this->common_model->getTable($aColumns, $where);
//        $output = $data['output'];
//        $i = $this->input->get_post('iDisplayStart', true) + 1;
//        foreach ($data['result'] as $aRow) {
//            $row = array();
//            foreach ($aColumns as $col) {
//                $col = trim($col, 'B.');
//                $row[] = $aRow[$col];
//            }
//            $row[0] = $i;
//            $i = $i + 1;
//
//
//            $output['aaData'][] = $row;
//        }
//        echo json_encode($output);
        $aColumns = array('business_invite_id', 'business_name', 'phone', 'B.email', 'H.hashcode');
        $this->common_model->initialise('invitebusiness as I');
        $this->common_model->join_tables = array('users as U', 'businesscore as B', 'hashurl as H');
        $this->common_model->join_on = array('I.user_id = U.id', 'I.business_id = B.id', 'H.user_id=I.business_invite_id');
        $where = array('H.type =' => 4);
        $data = $this->common_model->getTable($aColumns, $where);
        $output = $data['output'];
        $i = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();

            foreach ($aColumns as $key => $col) {
                $col = trim($col, 'B.');
                $col = trim($col, 'H.');

                $row[] = $aRow[$col];
            }
            $hashcode = $aRow['hashcode'];

            $row[0] = $i;
            $i = $i + 1;
            $row[4] = base_url() . "frontend/merchant/" . $hashcode;

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function followers_management() {
        $data = array();
        $this->common_model->initialise('merchant as M');
        $this->common_model->join_tables = array('users as U');
        $this->common_model->join_on = array('M.user_id = U.id');
        $where = 0;
        $data['followers_management'] = $this->common_model->get_records(0, '*', $where);
        $data['menuid'] = 'followers';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getfollowers() {
        $aColumns = array('U.id', 'business_name', 'phone', 'U.email', 'followers_management');
        $this->common_model->initialise('merchant as M');
        $this->common_model->join_tables = array('users as U');
        $this->common_model->join_on = array('M.user_id = U.id');
        $where = 0;
        $data = $this->common_model->getTable($aColumns, $where);
        $output = $data['output'];
        $i = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'M.');
                $col = trim($col, 'U.');
                $row[] = $aRow[$col];
            }
            $row[0] = $i;
            $i = $i + 1;
            $status = $aRow['followers_management'];

            if ($status == 1) {
                $statusn = "<button title='Medium' id='sc$i' style='border:0px solid #cccccc;'>Medium</button>";

                $statusc = "<input type='radio' id='f1' name='f1$i' value='0' onclick='return followers(this.value);' >&nbsp;Low<br><input type='radio' id='f1' name='f1$i' value='1' onclick='followers(this.value);' checked >&nbsp;Medium <br><input type='radio' id='f1' name='f1$i' value='2' onclick='followers(this.value);' >&nbsp;High";
            } else if ($status == 0 || $status == '' || $status == "NULL") {
                $statusn = "<button title='low' id='sc$i' style='border:0px solid #cccccc;'>Low</button>";

                $statusc = "<input type='radio' id='f1' name='f1$i' value='0' onclick='followers(this.value);' checked>&nbsp;Low<br><input type='radio' id='f1' name='f1$i' value='1' onclick='followers(this.value);' >&nbsp;Medium <br><input type='radio' id='f1' name='f1$i' value='2' onclick='followers(this.value);' >&nbsp;High";
            } else if ($status == 2) {
                $statusn = "<button title='high' id='sc$i' style='border:0px solid #cccccc;'>High</button>";
                $statusc = "<input type='radio' id='f1' name='f1$i' value='0' onclick='followers(this.value);' >&nbsp;Low<br><input type='radio' id='f1' name='f1$i' value='1' onclick='followers(this.value);'>&nbsp;Medium <br><input type='radio' id='f1' name='f1$i' value='2' onclick='followers(this.value);' checked >&nbsp;High";
            }

            $row[4] = $statusn;
            $row[5] = $statusc;
            $vali = "sc$i";
            $row[] = "<button class='btn' title='update' style='border:1px solid #cccccc;' data-id ='$vali' onclick='update_follow_status(" . $aRow['id'] . ", $i)'>Update</button>";
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function updatefollwers() {
        $data = array();
        if (!empty($_POST)) {
            $data = $_POST;
            $this->common_model->initialise('merchant');
            $this->common_model->array = $data;
            $where = array('user_id' => $_POST['user_id']);
            $result_update = $this->common_model->update($where);
            $followers = $this->common_model->get_record_single($where, '*');
        }

        return true;
    }

}

//class
