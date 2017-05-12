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
class Points extends My_Controller {

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
        $this->common_model->initialise('ichekpoints');
        $data['points'] = $this->common_model->get_records(0, '*', '');
        $data['menuid'] = 'pointslist';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function add() {
        $data = array();
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('activity_name', 'Activity Name', 'required|trim');
        $this->form_validation->set_rules('user_type', 'User Type', 'required|trim');
        $this->form_validation->set_rules('activity_points', 'Activity Points', 'required|trim');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        $this->form_validation->set_message('check_default', 'Please select something for the %s field');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if (isset($_POST['submit'])) {

            if ($this->form_validation->run() == FALSE) {

                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('activity_name' => $_POST['activity_name'], 'activity_points' => $this->input->post('activity_points'), 'user_type' => $this->input->post('user_type'));
                $this->common_model->initialise('ichekpoints');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                redirect(base_url() . "Admin/points/pointslist");
            }
        }

        $data['menuid'] = 'addpoints';
        $this->layout->view($this->view_dir, $data);
    }

    public function update($id) {
        $this->common_model->initialise('ichekpoints');
        $data['admin_base_url'] = $this->admin_base_url;
        $data['point'] = $this->common_model->get_record_single(array('id' => $id), '*');

        //update query
        if (!empty($_POST)) {

            $data = array('activity_points' => $this->input->post('activity_points'));
            unset($data['submit']);

            $this->common_model->initialise('ichekpoints');
            $this->common_model->array = $data;
            $where = array('id' => $id);

            $result_update = $this->common_model->update($where);
            $data['point'] = $this->common_model->get_record_single(array('id' => $id), '*');
            redirect(base_url() . "Admin/points/");
        }
        $data['menuid'] = 'pointslist';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function pointsstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }

        $data = $statusn;

        $this->common_model->initialise('ichekpoints');
        $this->common_model->status = $data;
        $where = array('id' => $id);

        $this->common_model->set_status($where);
        $data['menuid'] = 'pointslist';
        redirect(base_url() . "Admin/points/");
    }

}
