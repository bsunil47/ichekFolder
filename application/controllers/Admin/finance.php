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
class Finance extends My_Controller {

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
        // Add user data in session
        $data = array();
        $this->common_model->initialise('users as U');
        $this->common_model->join_tables = array('cashout as C');
        $this->common_model->join_on = array('U.id = C.user_id');
        $where = 0;
        $data['finance'] = $this->common_model->get_records(0, '*', $where, 'C.datecreated');
        $data['menuid'] = 'cashout';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function topuplist() {
        // Add user data in session
        $data = array();
        $this->common_model->initialise('users as U');
        $this->common_model->join_tables = array('topup as T');
        $this->common_model->join_on = array('U.id = T.user_id');
        $where = 0;
        $data['topup'] = $this->common_model->get_records(0, '*', $where, 'T.id', 'desc');
        $data['menuid'] = 'topup';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getData() {
        $aColumns = array('U.id', 'firstname', 'lastname', 'email', 'amount', 'datecreated');
        $this->common_model->initialise('users as U');
        $this->common_model->join_tables = array('cashout as C');
        $this->common_model->join_on = array('U.id = C.user_id');
        $where = 0;
        $data = $this->common_model->getTable($aColumns, $where, 'datecreated');
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'U.');
                $row[] = $aRow[$col];
            }
            $row[0] = $j;
            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function getTopup() {
        $aColumns = array('U.id', 'firstname', 'lastname', 'email', 'amount', 'datecreated');
        $this->common_model->initialise('users as U');
        $this->common_model->join_tables = array('topup as T');
        $this->common_model->join_on = array('U.id = T.user_id');
        $where = 0;
        $data = $this->common_model->getTable($aColumns, $where, 'datecreated');
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'U.');
                $row[] = $aRow[$col];
            }
            $row[0] = $j;
            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

}
