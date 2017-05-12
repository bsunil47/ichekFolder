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
 * @author LENOVO
 */
// session_start();
class Settings extends My_Controller {

    private $view_dir;

    //put your code here
    public function __construct() {
        parent::__construct();
        if ($this->router->fetch_method() != 'index') {
            if (!$this->_is_logged_in()) {
                redirect(base_url() . "Admin");
            }
        }
        $this->view_dir = 'admin/' . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('admin_main.php');
    }

    /* public function index(){
      $data = array();
      $data['id'] = $this->session->userdata('admin_user_id');
      $this->layout->setLayout('admin_login.php');
      $this->layout->view($this->view_dir, $data);
      } */

    public function add() {
        $data = array();
        $id = $this->session->userdata('admin_user_id');
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('cpc', 'Cpc', 'required|trim');
        $this->form_validation->set_rules('paypal_id', 'Paypal Id', 'required|trim');
        $this->form_validation->set_rules('cashout_min_points', 'Cashout Min Points', 'required|trim');
        $this->form_validation->set_rules('cash_out_fee', 'Cashout Fee', 'required|trim');
        $this->form_validation->set_rules('max_cash_out', 'Max Cashout', 'required|trim');

        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        $this->form_validation->run();
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {

                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                if ($_POST['status'] == 1) {
                    $data = $_POST;
                    $statusn = 0;
                    $where = 0;
                    $data = array('status' => $statusn);
                    $this->common_model->initialise('icheksettings');
                    $this->common_model->array = $data;
                    $this->common_model->updaten($where);
                }

                $data = array('cpc' => $this->input->post('cpc'), 'paypal_id' => $this->input->post('paypal_id'), 'cashout_min_points' => $this->input->post('cashout_min_points'), 'cash_out_fee' => $this->input->post('cash_out_fee'), 'max_cash_out' => $this->input->post('max_cash_out'), 'created_by' => $this->session->userdata('admin_user_id'), 'status' => $this->input->post('status'));

                $this->common_model->initialise('icheksettings');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $id = $this->db->insert_id();
            }
        }

        $this->layout->view($this->view_dir, $data);
        //redirect(base_url() . "Admin/settings/settingslist");
    }

    public function index() {
        $data = array();
        $this->common_model->initialise('icheksettings');
        $data['settings'] = $this->common_model->get_records(0, '*', '');
        //$this->common_model->insert_entry();
        $this->layout->view($this->view_dir, $data);
    }

    public function edit($id) {
        $data = array();
        $this->common_model->initialise('icheksettings');
        $data['settings'] = $this->common_model->get_record_single(array('icheksetting_id' => $id), '*');

        //update query
        if (!empty($_POST)) {

            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('icheksettings');
            $this->common_model->array = $data;
            $where = array('icheksetting_id' => $id);

            $result_update = $this->common_model->update($where);

            $data['settings'] = $this->common_model->get_record_single(array('icheksetting_id' => $id), '*');
            redirect(base_url() . "Admin/settings/settingslist");
        }

        $this->layout->view($this->view_dir, $data);
    }

    public function settingstatus($id, $status) {
        $statusn = 0;
        $data = array('status' => $statusn);
        $this->common_model->initialise('icheksettings');
        $this->common_model->array = $data;
        $where = 0;
        $this->common_model->updaten($where);
        $statusnew = 1;
        $datan = array('status' => $statusnew);
        $this->common_model->array = $datan;
        $where = array('icheksetting_id =' => $id);

        $this->common_model->update($where);

        redirect(base_url() . "Admin/settings/settingslist");
    }

}
