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
class Review extends My_Controller {

    private $view_dir;

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->admin_base_url = base_url() . 'Admin/' . $this->router->fetch_class();

        if (!$this->_is_logged_in()) {
            redirect(base_url() . "Admin");
        }
        $this->view_dir = 'admin/' . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('admin_main.php');
    }

    public function index() {
        $data = array();
        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U','review_messages as RM');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id');
        $where = 0;
        $data['reviews'] = $this->common_model->get_records(0, 'OFR.id_customer,RM.message as review,OFR.status,OFR.id,U.firstname,U.lastname', $where);
        //echo '<pre>';
        //print_r($data); exit;
        $data['menuid'] = 'reviews';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function edit($id) {
        $data = array();
        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U','review_messages as RM');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id');
        $data['reviews'] = $this->common_model->get_record_single(array('RM.review_messages_id' => $id), '*,RM.message as review');

        //update query
        if (!empty($_POST)) {

            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('review_messages');
            $this->common_model->array = ['message' => $data['review']];
            $where = array('review_messages_id' => $data['reviews']->review_messages_id);
            $result_update = $this->common_model->update($where);
            //$data['reviews'] = $this->common_model->get_record_single(array('id' => $id), '*');
            redirect(base_url() . "Admin/review/");
        }
        $data['menuid'] = 'reviews';
        $this->layout->view($this->view_dir, $data);
    }

    public function reviewstatus($id, $status) {
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }
        if ($status == 2) {
            $statusn = 1;
        }
        $data = $statusn;
        $this->common_model->initialise('review_messages');
        $this->common_model->status = $data;
        $where = array('review_messages_id' => $id);
        $this->common_model->set_status($where);
        redirect(base_url() . "Admin/review/reports");
    }

    public function reports() {
        $data = array();

        $this->common_model->initialise('offerreviews');
        $this->common_model->array = array('viewstatus' => 1);
        $where = array('status' => 2);
        $n = $this->common_model->update($where);

        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U','review_messages as RM','offers as O','merchant as M','users as MU');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id','O.id = OFR.id_offer','M.user_id = O.user_id','M.user_id = MU.id');
        $where = array('OFR.status' => 2);

        $data['reports'] = $this->common_model->get_records(0, '*,RM.message as review, OFR.id_customer, OFR.status,OFR.id,U.firstname,U.lastname,review_messages_id, MU.firstname as merchant_firstname, MU.lastname as merchant_lastname,M.mobile as merchant_mobile,U.mobile as customer_mobile,MU.email as merchant_email,U.email as customer_email, M.user_id as id_merchant, MU.facebook_id as merchant_facebook_id, U.facebook_id as customer_facebook_id', $where);
        $data['menuid'] = 'reportedreviews';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function reportsedit($id) {
        $data = array();
        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U','review_messages as RM');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id');
        $data['reports'] = $this->common_model->get_record_single(array('review_messages_id' => $id), '*,RM.message as review');
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('review_messages');
            $this->common_model->array = ['message' => $data['review']];
            $where = array('review_messages_id' => $id);
            $result_update = $this->common_model->update($where);
            $data['reports'] = $this->common_model->get_record_single(array('review_messages_id' => $id), '*');
            redirect(base_url() . "Admin/review/reports");
        }
        $data['menuid'] = 'reportedreviews';
        $this->layout->view($this->view_dir, $data);
    }

    public function getData() {
        $aColumns = array('RM.review_messages_id', 'U.firstname','M.display_name', 'RM.message', 'OFR.status','U.lastname', 'MU.firstname as merchant_firstname', 'MU.lastname as merchant_lastname','M.mobile as merchant_mobile','U.mobile as customer_mobile','MU.email as merchant_email','U.email as customer_email', 'M.user_id as id_merchant', 'MU.facebook_id as merchant_facebook_id', 'U.facebook_id as customer_facebook_id');
        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U','review_messages as RM','offers as O','merchant as M','users as MU');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id','O.id = OFR.id_offer','M.user_id = O.user_id','M.user_id = MU.id');
        //$this->common_model->join_tables = array('users as U','review_messages as RM','offers as O','merchant as M');
        //$this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id','O.id = OFR.id_offer','M.user_id = O.user_id');

        //$this->common_model->join_tables = array('users as U','review_messages as RM');
        //$this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id');
        $where = 0;
        $data = $this->common_model->getTable($aColumns, $where);
        $output = $data['output'];
        $i = $this->input->get_post('iDisplayStart') + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'U.');
                $col = trim($col, 'OFR.');
                $col = trim($col, 'RM.');
                $col = trim($col, 'M.');
                $col = trim($col, 'MU.');

                $row[] = $aRow[$col];
            }
            if(file_exists(base_url().$aRow['id_merchant'].'/assert.jpg')){
                $merchant_pic = base_url().$aRow['id_merchant'].'/assert.jpg';
            }elseif(!empty($aRow['merchant_facebook_id'])){
                $merchant_pic = "http://graph.facebook.com/{$aRow['merchant_facebook_id']}/picture?type=normal";
            }else{
                $merchant_pic = base_url().'images/user.png';
            }

            if(file_exists(base_url().$aRow['id_customer'].'/assert.jpg')){
                $customer_pic = base_url().$aRow['id_customer'].'/assert.jpg';
            }elseif(!empty($aRow['customer_facebook_id'])){
                $customer_pic = "http://graph.facebook.com/{$aRow['customer_facebook_id']}/picture?type=normal";
            }else{
                $customer_pic = base_url().'images/user.png';
            }
            $row[0] = $i;
            $i = $i + 1;
            $row[1] = "<span style=\"cursor: pointer; text-decoration: underline\" class=\"popup_display\" onclick='popupDiv(this)' data-image_url=\"$customer_pic \" data-usertype=\"5\" data-title=\"Customer Details\" data-mobile=\"{$aRow['customer_mobile']}\" data-email=\"{$aRow['customer_email']}\" data-name=\"$row[1]\">$row[1]</span>";
            $row[2] = "<span style=\"cursor: pointer; text-decoration: underline\" class=\"popup_display\" onclick='popupDiv(this)' data-image_url=\"$merchant_pic \" data-usertype=\"4\" data-title=\"Merchant Details\" data-mobile=\"{$aRow['merchant_mobile']}\" data-email=\"{$aRow['merchant_email']}\" data-name=\"\" data-business_name=\"$row[2]\">$row[2]</span>";
            //$string = $this->emoji_softbank_to_unified($row[2]);
            //$row[2] = $this->emoji_unified_to_html($string);
            //$working = json_encode($row[2]);
            //$working = preg_replace('/\\\u([0-9a-z]{4})/', '&#x$1;', $row[2]);
            //$unicodeChar = '\u1000';
            //echo json_decode('"'.$row[2].'"');
            //$encoding = ini_get('default_charset');
            //$row[2] =  preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/u', function($match) use ($encoding) {
            //    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UTF-16BE');
           // }, $row[2]);
            $row[3] = json_decode('"'.$row[3].'"');
            //$string = preg_replace('/%u([0-9A-F]+)/', '&#x$1;', $row[2]);
            //$row[2] = html_entity_decode($row[2]);
            //$encoding = ini_get('mbstring.internal_encoding');
            //$row[2] = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/u', create_function('$match', 'return mb_convert_encoding(pack("H*", $match[1]), '.var_export($encoding, true).', "UTF-16BE");'),$row[2]);
            $status = $aRow['status'];
            if ($status == 1) {
                $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Reviewed</button>";
            } else if ($status == 0 || $status == '' || $status == "NULL") {
                $statusn = "<button class='btn-info' title='Inactive' style='border:0px solid #cccccc;'>Review</button>";
            } else if ($status == 2) {
                $statusn = "<button class='btn-danger' title='process' style='border:0px solid #cccccc;'>Reported</button>";
            }

            $row[4] = $statusn;

            $row[5] = '<a href="' . base_url() . 'Admin/review/edit/' . $aRow['review_messages_id'] . '"><button class="btn" title="edit" style="border:1px solid #cccccc;">Edit</button></a>';
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function getDataReports() {
        $aColumns = array('RM.review_messages_id', 'firstname','M.display_name', 'RM.message', 'OFR.status');
        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U','review_messages as RM','offers as O','merchant as M');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id = RM.review_id','O.id = OFR.id_offer','M.user_id = O.user_id');

        $where = array('OFR.status' => 2);
        $data = $this->common_model->getTable($aColumns, $where);
        $output = $data['output'];
        $i = $this->input->get_post('iDisplayStart') + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'OFR.');
                $col = trim($col, 'RM.');
                $col = trim($col, 'M.');
                $row[] = $aRow[$col];
            }
            $row[0] = $i;
            $i = $i + 1;
            $row[3] = json_decode('"'.$row[3].'"');
            $status = $aRow['status'];
            if ($status == 1) {
                $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Reviewed</button>";
            } else if ($status == 0 || $status == '' || $status == "NULL") {
                $statusn = "<button class='btn-info' title='Inactive' style='border:0px solid #cccccc;'>Review</button>";
            } else if ($status == 2) {
                $statusn = "<button class='btn-danger' title='process' style='border:0px solid #cccccc;'>Reported</button>";
            }

            $row[4] = $statusn;

            $row[] = '<a href="' . base_url() . 'Admin/review/reportsedit/' . $aRow['review_messages_id'] . '"><button class="btn" title="edit" style="border:1px solid #cccccc;">Edit</button></a>&nbsp;<a href="' . base_url() . 'Admin/review/reviewstatus/' . $aRow['review_messages_id'] . '/' . $aRow['status'] . '"><button class="btn" title="status" style="border:1px solid #cccccc;">Status</button></a>';
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

}
