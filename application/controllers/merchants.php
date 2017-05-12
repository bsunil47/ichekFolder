<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();
//base_url()= "http://localhost/icheck_d11-03-2015/merchants";
//$url = $this->config->base_url();
//echo $url;
//echo base_url();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of frontend
 *
 * @author Kesav
 */
class Merchants extends My_Controller {

    private $view_dir;
    private $admin_base_url;

    public function __construct() {

        parent::__construct();
        //echo base_url();

        if (!$this->_is_home_logged_in()) {
            redirect(base_url());
        }

        $this->view_dir = $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('merchants_main.php');
    }

    /* public function index() {

      $data = array('email' => $this->input->post('email'), 'password' => $this->input->post('password'));
      if (isset($_POST['submit'])) {
      $this->load->library('form_validation');
      //set rules here
      $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
      $this->form_validation->set_rules('password', 'Password', 'required|trim');
      // set messages
      $this->form_validation->set_message('required', '%s should not be empty');
      $this->form_validation->set_message('valid_email', '%s should be an valid email');
      if ($this->form_validation->run() == FALSE) {
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      } else {
      $data = array('email' => $this->input->post('email'), 'password' => $this->input->post('password'));
      $this->common_model->initialise('users');
      $result = $this->common_model->get_record_single($data, '*');

      if (!empty($result)) {
      $this->common_model->initialise('user_types');
      $result_s = $this->common_model->get_record_single(array('user_id' => $result->id, 'user_type =' => 4), '*');
      if (!empty($result_s)) {
      $this->session->set_userdata('user_id', $result->id);
      $this->session->set_userdata('firstname', $result->firstname);
      $this->session->set_userdata('lastname', $result->lastname);
      $this->session->set_userdata('email', $result->email);
      $this->session->set_userdata('user_type', $result_s->user_type);
      redirect($this->admin_base_url.'merchants/dashboard');

      }

      else {
      $this->setFlashmessage('error', 'Not able to login');
      redirect($this->admin_base_url, 'refresh');
      }
      }

      else {
      $this->setFlashmessage('error', 'Invalid Username or Password');
      redirect($this->admin_base_url, 'refresh');
      }

      }

      }
      $this->layout->setLayout('merchants_login.php');
      $this->layout->view($this->view_dir,$data);
      } */

    public function index() {
        $data = array();
        /* $this->common_model->initialise('user_types');
          $select = 'COUNT(user_type) as count';
          //$data['users'] = $this->common_model->get_record_single(array('user_type <' => 4), $select);
          $data['merchant'] = $this->common_model->get_record_single(array('user_type' => 4), $select);
          $data['followers'] = $this->common_model->get_record_single(array('user_type' => 5), $select);
          if (($handle = fopen(FCPATH . "log/log_login.csv", "r")) !== FALSE && filesize(FCPATH . "log/log_login.csv") != 0) {
          while (($data_csv = fgetcsv($handle)) !== FALSE) {
          if ($data_csv[0] == 4) {
          $data['gr'][$data_csv[2]]['merchant'] = $data_csv[1];
          $data['merchant_g'][] = $data_csv;
          } else {
          $data['gr'][$data_csv[2]]['customer'] = $data_csv[1];
          $data['customer_g'][] = $data_csv;
          }
          }
          fclose($handle);
          }
          for ($i = 0; $i < 7; $i++) {
          $data['dates'][] = date("Y-m-d", strtotime($i . " days ago"));
          } */

        $this->common_model->initialise('cashout');
        $select = 'SUM(amount) as cashout';
        $where = "DATE(datecreated) > DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND user_id = " . $this->session->userdata('user_id');
        $data['cahoutsum'] = $this->common_model->get_record_single($where, $select);

        $this->common_model->initialise('topup');
        $select = 'SUM(amount) as topup';
        $where = "DATE(datecreated) > DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND user_id = " . $this->session->userdata('user_id');
        $data['topupsum'] = $this->common_model->get_record_single($where, $select);

        $this->common_model->initialise('followers');
        $select = 'COUNT(*) as fcount';
        $where = "id_user = " . $this->session->userdata('user_id');
        $data['follower'] = $this->common_model->get_record_single($where, $select);

        //echo '<pre>';
        //print_r($data); exit;
        $this->layout->view($this->view_dir, $data);
    }

    public function follower() {
        $data = array();
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getfollowers() {
        $data = array();
        $aColumns = array('firstname', 'email', 'F.datecreated');
        $this->common_model->initialise('followers as F');
        $this->common_model->join_tables = 'users as U';
        $this->common_model->join_on = "U.id = F.id_follower";
        $where = array('F.id_user ' => $this->session->userdata('user_id'));
        $data = $this->common_model->getTable($aColumns, $where, $col = 0, $order = 'desc', $groupby = NULL);
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            $row[0] = $j;
            foreach ($aColumns as $col) {
                $col = trim($col, 'F.');
                $row[] = $aRow[$col];
            }
            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function emailblast() {
        $data = array();
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getemaillist() {
        $data = array();
        $aColumns = array('message', 'amount', 'datecreated');
        $this->common_model->initialise('blast');
        $where = array('user_id ' => $this->session->userdata('user_id'));
        $data = $this->common_model->getTable($aColumns, $where, $col = 0, $order = 'desc', $groupby = NULL);
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            $row[0] = $j;
            foreach ($aColumns as $col) {
                $row[] = $aRow[$col];
            }
            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function cashout() {
        $data = array();
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getcashout() {
        $data = array();
        $aColumns = array('amount', 'datecreated');
        $this->common_model->initialise('cashout');
        $where = array('user_id ' => $this->session->userdata('user_id'));
        $data = $this->common_model->getTable($aColumns, $where, $col = 0, $order = 'desc', $groupby = 0);
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            $row[0] = $j;
            foreach ($aColumns as $col) {
                $col = trim($col, 'F.');
                $row[] = $aRow[$col];
            }
            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function topup() {
        $data = array();
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function gettopup() {
        $data = array();
        $aColumns = array('amount', 'datecreated');
        $this->common_model->initialise('topup');
        $where = array('user_id ' => $this->session->userdata('user_id'));
        $data = $this->common_model->getTable($aColumns, $where, $col = 0, $order = 'desc', $groupby = 0);
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            $row[0] = $j;
            foreach ($aColumns as $col) {
                $col = trim($col, 'F.');
                $row[] = $aRow[$col];
            }
            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

}

//class
