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
        $this->admin_base_url = base_url() . 'Admin/' . $this->router->fetch_class();

        if (!$this->_is_logged_in()) {
            redirect(base_url() . "Admin");
        }
        $this->view_dir = 'admin/' . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('admin_main.php');
    }

    public function index() {
        $data = array();
        $this->common_model->initialise('icheksettings');
        $data['settings'] = $this->common_model->get_records(0, '*', '');
        $data['menuid'] = 'setlist';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

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
        $this->form_validation->set_rules('max_cash_out_fee', 'Max Cashout Fee', 'required|trim');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                if ($_POST['status'] == 1) {
                    $data = $_POST;
                    $statusn = 0;
                    $where = array('status' => 1);
                    $data = array('status' => $statusn);
                    $this->common_model->initialise('icheksettings');
                    $this->common_model->array = $data;
                    $this->common_model->update($where);
                }

                $data = array('cpc' => $this->input->post('cpc'), 'paypal_id' => $this->input->post('paypal_id'), 'cashout_min_points' => $this->input->post('cashout_min_points'), 'cash_out_fee' => $this->input->post('cash_out_fee'), 'max_cash_out' => $this->input->post('max_cash_out'), 'max_cash_out_fee' => $this->input->post('max_cash_out_fee'), 'created_by' => $this->session->userdata('admin_user_id'), 'status' => $this->input->post('status'));

                $this->common_model->initialise('icheksettings');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $id = $this->db->insert_id();
                redirect(base_url() . "Admin/settings/");
            }
        }
        $data['menuid'] = 'setadd';
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
            redirect(base_url() . "Admin/settings/");
        }
        $data['menuid'] = 'setlist';
        $this->layout->view($this->view_dir, $data);
    }

    public function settingstatus($id, $status) {
        $statusn = 0;
        $data = array('status' => $statusn);
        $this->common_model->initialise('icheksettings');
        $this->common_model->array = $data;
        $where = "icheksetting_id != " . $id;
        $this->common_model->update($where);
        $statusnew = 1;
        $datan = array('status' => $statusnew);
        $this->common_model->array = $datan;
        $where = array('icheksetting_id =' => $id);
        $this->common_model->update($where);
        redirect(base_url() . "Admin/settings/");
    }

    public function getData() {
        $aColumns = array('icheksetting_id', 'cpc', 'paypal_id', 'cashout_min_points', 'max_cash_out', 'status');
        $this->common_model->initialise('icheksettings');
        $where = 0;
        $data = $this->common_model->getTable($aColumns, $where);
        $output = $data['output'];
        $i = $this->input->get_post('iDisplayStart') + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {

                $row[] = $aRow[$col];
            }
            $row[0] = $i;
            $i = $i + 1;

            $status = $aRow['status'];
            if ($status == 1) {
                $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Active</button>";
            } else if ($status == 0 || $status == '' || $status == "NULL") {
                $statusn = "<button class='btn-danger' title='Inactive' style='border:0px solid #cccccc;'>Inactive</button>";
            }

            $row[5] = $statusn;

            $row[] = '<a href="' . base_url() . 'Admin/settings/edit/' . $aRow['icheksetting_id'] . '"><button class="btn" title="edit" style="border:1px solid #cccccc;">Edit</button></a>&nbsp;<a href="' . base_url() . 'Admin/settings/settingstatus/' . $aRow['icheksetting_id'] . '/' . $aRow['status'] . '"><button class="btn" title="status" style="border:1px solid #cccccc;">Status</button></a>';
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function categories() {
        $data = array();
        $this->common_model->initialise('categories');
        $data['settings'] = $this->common_model->get_records(0, '*', '');
        $data['menuid'] = 'categories';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function addcat() {
        $data = array();
        $id = $this->session->userdata('admin_user_id');
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('catname', 'Category', 'required|trim');

        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                if ($_POST['status'] == 1) {
                    $data = $_POST;
                    $statusn = 0;
                    $where = array('status' => 1);
                    $data = array('status' => $statusn);
                    $this->common_model->initialise('categories');
                    $this->common_model->array = $data;
                    $this->common_model->update($where);
                }

                $data = array('name' => $this->input->post('catname'), 'status' => $this->input->post('status'));

                $this->common_model->initialise('categories');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $id = $this->db->insert_id();
                redirect(base_url() . "Admin/settings/categories");
            }
        }
        $data['menuid'] = 'catadd';
        $this->layout->view($this->view_dir, $data);
    }

    public function getcatData() {
        $aColumns = array('id', 'name', 'status');
        $this->common_model->initialise('categories');
        $where = 0;
        $data = $this->common_model->getTable($aColumns, $where);
        $output = $data['output'];
        $i = $this->input->get_post('iDisplayStart') + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {

                $row[] = $aRow[$col];
            }
            $row[0] = $i;
            $i = $i + 1;

            $status = $aRow['status'];
            if ($status == 1) {
                $statusn = "<button class='btn-success' title='Active' style='border:0px solid #cccccc;'>Active</button>";
            } else if ($status == 0 || $status == '' || $status == "NULL") {
                $statusn = "<button class='btn-danger' title='Inactive' style='border:0px solid #cccccc;'>Inactive</button>";
            }

            $row[2] = $statusn;

            $row[] = '<a href="' . base_url() . 'Admin/settings/catedit/' . $aRow['id'] . '"><button class="btn" title="edit" style="border:1px solid #cccccc;">Edit</button></a>&nbsp;<a href="' . base_url() . 'Admin/settings/catstatus/' . $aRow['id'] . '/' . $aRow['status'] . '"><button class="btn" title="status" style="border:1px solid #cccccc;">Status</button></a>';
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function catstatus($id, $status) {
        $this->common_model->initialise('categories');
        $where = array('id' => $id);
        $record = $this->common_model->get_record_single($where, 'status');
        $statusn = 0;
        if ($record->status == 0) {
            $statusn = 1;
        }
        $data = array('status' => $statusn);
        $this->common_model->array = $data;
        $this->common_model->update($where);
        print_r($data);
        redirect(base_url() . "Admin/settings/categories");
    }

    public function catedit($id) {
        $data = array();
        $this->common_model->initialise('categories');
        $data['settings'] = $this->common_model->get_record_single(array('id' => $id), '*');
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('categories');
            $this->common_model->array = $data;
            $where = array('id' => $id);
            $result_update = $this->common_model->update($where);
            $data['settings'] = $this->common_model->get_record_single(array('id' => $id), '*');
            redirect(base_url() . "Admin/settings/categories");
        }
        $data['menuid'] = 'setlist';
        $this->layout->view($this->view_dir, $data);
    }

    public function status() {
        $data = array();
        $this->common_model->initialise('points_status');
        $data['settings'] = $this->common_model->get_records(0, '*', '');
        $data['menuid'] = 'status';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function addstatus() {
        $data = array();
        $id = $this->session->userdata('admin_user_id');
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('points', 'Points', 'required|trim|numeric');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        $this->form_validation->set_message('numeric', '%s Should be a Numeric ');
        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('name' => $this->input->post('name'), 'points' => $this->input->post('points'));
                $this->common_model->initialise('points_status');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $id = $this->db->insert_id();
                redirect(base_url() . "Admin/settings/status");
            }
        }
        $data['menuid'] = 'statadd';
        $this->layout->view($this->view_dir, $data);
    }

    public function statstatus($id, $status) {
        $this->common_model->initialise('points_status');
        $where = array('points_status_id' => $id);
        $record = $this->common_model->get_record_single($where, 'status');
        $statusn = 0;
        if ($record->status == 0) {
            $statusn = 1;
        }
        $data = array('status' => $statusn);
        $this->common_model->array = $data;
        $this->common_model->update($where);
        print_r($data);
        redirect(base_url() . "Admin/settings/status");
    }

    public function statusedit($id) {
        $data = array();
        $this->common_model->initialise('points_status');
        $data['settings'] = $this->common_model->get_record_single(array('points_status_id' => $id), '*');
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('points_status');
            $this->common_model->array = $data;
            $where = array('points_status_id' => $id);
            $result_update = $this->common_model->update($where);
            $data['settings'] = $this->common_model->get_record_single(array('points_status_id' => $id), '*');
            redirect(base_url() . "Admin/settings/status");
        }
        $data['menuid'] = 'statusedit';
        $this->layout->view($this->view_dir, $data);
    }

}
