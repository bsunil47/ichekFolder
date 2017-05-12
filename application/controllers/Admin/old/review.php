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
        redirect(base_url() . "Admin/review/reviewlist");
    }

    public function reviewlist() {
        $data = array();

        $this->common_model->initialise('offerreviews as OFR');
        $this->common_model->join_tables = array('users as U', 'merchant as ME');
        $this->common_model->join_on = array('OFR.id_customer = U.id', 'OFR.id_merchant = ME.user_id');
        $data['reviews'] = $this->common_model->get_records(0, 'OFR.id_customer,OFR.id_merchant,OFR.review,OFR.status,OFR.id,U.firstname,ME.business_name', '');

        $data['menuid'] = 'reviews';
        $this->layout->view($this->view_dir, $data);
    }

    public function edit($id) {
        $data = array();
        $this->common_model->initialise('offerreviews');
        $data['reviews'] = $this->common_model->get_record_single(array('id' => $id), '*');
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            //print_r($data);exit;
            $this->common_model->initialise('offerreviews');
            $this->common_model->array = $data;
            $where = array('id' => $id);
            $result_update = $this->common_model->update($where);
            $data['reviews'] = $this->common_model->get_record_single(array('id' => $id), '*');
            redirect(base_url() . "Admin/review/reviewlist");
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
        $data = $statusn;
        $this->common_model->initialise('offerreviews');
        $this->common_model->status = $data;
        $where = array('id' => $id);
        $this->common_model->set_status($where);
        redirect(base_url() . "Admin/review/reviewlist");
    }

}
