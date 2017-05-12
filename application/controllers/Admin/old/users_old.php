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
class Users extends My_Controller {

    private $view_dir;
    private $admin_base_url;

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->admin_base_url = base_url() . 'Admin';
        $allowed_urls = array('index', 'forgotpassword');
        if (!in_array($this->router->fetch_method(), $allowed_urls)) {
            if (!$this->_is_logged_in()) {
                redirect(base_url() . "Admin");
            }
        }
        $this->view_dir = 'admin/' . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('admin_main.php');
    }

    public function index() {

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
                    $result_s = $this->common_model->get_record_single(array('user_id' => $result->id, 'user_type <' => 4), '*');
                    //print_r($result); exit;
                    if (!empty($result_s)) {
                        $this->session->set_userdata('admin_user_id', $result->id);
                        $this->session->set_userdata('firstname', $result->firstname);
                        $this->session->set_userdata('lastname', $result->lastname);
                        $this->session->set_userdata('email', $result->email);
                        $this->session->set_userdata('user_type', $result_s->user_type);
                        redirect($this->admin_base_url . '/users/dashboard');
                    } else {
                        $this->setFlashmessage('error', 'Not able to login');
                        redirect($this->admin_base_url, 'refresh');
                    }
                } else {
                    $this->setFlashmessage('error', 'Invalid Username or Password');
                    redirect($this->admin_base_url, 'refresh');
                }
            }
        }

        $this->layout->setLayout('admin_login.php');
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function dashboard() {
        // Add user data in session
        // Add user data in session
        $data = array();
        $this->common_model->initialise('user_types');
        $select = 'COUNT(user_type) as count';
        $data['users'] = $this->common_model->get_record_single(array('user_type <' => 4), $select);
        $data['merchant'] = $this->common_model->get_record_single(array('user_type' => 4), $select);
        $data['customers'] = $this->common_model->get_record_single(array('user_type' => 5), $select);
        $this->layout->view($this->view_dir, $data);
    }

    public function forgotpassword() {
        date_default_timezone_set('America/Los_Angeles');

        $data = array();
        if (!empty($_POST) && !empty($_POST['email'])) {
            $this->common_model->initialise('users');
            $user_record = $this->common_model->get_record_single(array('email' => $_POST['email']), '*');
            if (!empty($user_record)) {
                $this->common_model->initialise('hashurl');
                $code = hash('sha512', hash('md5', $_POST['email']) . hash('md5', date('ymdHis')));
                $this->common_model->array = array('user_id' => $user_record->id, 'hashcode' => $code);
                $hashcode = $this->common_model->insert_entry();
                $data['info']['success'] = "Successfully sent change password link to your mail";
                $this->load->model('communication_model');
                $this->communication_model->send_recover_code(array('email' => $_POST['email'], 'message' => $code, 'firstname' => $user_record->firstname));
            } else {
                $data['error'] = 'Not registered with us';
            }
        } else {
            $data['error'] = 'No Content';
        }
        $this->layout->setLayout('admin_login.php');
        $this->layout->view($this->view_dir, $data);
    }

    public function logout() {
        $this->session->unset_userdata('admin_user_id');
        redirect(base_url() . "Admin");
    }

    public function userlist() {

        $data = array();
        $this->common_model->initialise('user_types');
        $result_id = $this->common_model->get_records(0, '*', array('user_type <' => 4));

        foreach ($result_id as $row) {
            $uid = $row->user_id;
            $this->common_model->initialise('users');
            $data['users'][] = $this->common_model->get_record_single(array('id' => $row->user_id), '*');
        }

        $this->layout->view($this->view_dir, $data);
    }

    public function merchants() {

        $data = array();
        $this->common_model->initialise('user_types');
        $result = $this->common_model->get_records(0, 'user_id', array('user_type =' => 4));
        $res = implode(',', array_map('current', $result));
        $this->common_model->initialise('users');
        $data['merchants'] = $this->common_model->get_records('*', '*', "id in($res)");
        $this->layout->view($this->view_dir, $data);
    }

    public function customers() {
        $data = array();
        $this->common_model->initialise('user_types');
        $result_id = $this->common_model->get_records(0, 'user_id', array('user_type =' => 5));
        $result_id = implode(',', array_map('current', (array) $result_id));
        $this->common_model->initialise('users');
        $data['customers'] = $this->common_model->get_records(0, '*', "id IN ({$result_id})");
        $this->layout->view($this->view_dir, $data);
    }

    public function update($id) {


        $data = array();
        $this->common_model->initialise('users');
        $data['users'] = $this->common_model->get_record_single(array('id' => $id), '*');

        //update query
        if (!empty($_POST)) {

            $data = $_POST;
            unset($data['submit']);
            //print_r($data);exit;
            $this->common_model->initialise('users');
            $this->common_model->array = $data;
            $where = array('id' => $id);

            $result_update = $this->common_model->update($where);

            $data['users'] = $this->common_model->get_record_single(array('id' => $id), '*');
        }

        $this->layout->view($this->view_dir, $data);
    }

    public function userstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }

        $data = $statusn;

        $this->common_model->initialise('users');
        $this->common_model->status = $data;
        $where = array('id' => $id);

        $this->common_model->set_status($where);

        redirect(base_url() . "Admin/users/userlist");
    }

    public function customerstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }

        $data = $statusn;

        $this->common_model->initialise('users');
        $this->common_model->status = $data;
        $where = array('id' => $id);

        $this->common_model->set_status($where);

        redirect(base_url() . "Admin/users/customers");
    }

    public function merchantstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }

        $data = $statusn;

        $this->common_model->initialise('users');
        $this->common_model->status = $data;
        $where = array('id' => $id);

        $this->common_model->set_status($where);

        redirect(base_url() . "Admin/users/merchants");
    }

    public function add() {
        $data = array();

        if (isset($_POST['submit'])) {
            $this->load->library('form_validation');

            //set rules here
            $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]+$/]|trim');
            $this->form_validation->set_rules('status', 'User Type', 'required|trim');
            $this->form_validation->set_rules('address', 'Address', 'required|trim');

            // set messages
            $this->form_validation->set_message('required', '%s should not be empty');
            $this->form_validation->set_message('valid_email', '%s should be an valid email');


            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                //$this->layout->view($this->view_dir, $data);
            } else {
                echo 'asd';
                $data = array('firstname' => $this->input->post('firstname'), 'lastname' => $this->input->post('lastname'), 'email' => $this->input->post('email'));

                $this->common_model->initialise('users');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $id = $this->db->insert_id();

                $data_usertype = array('user_id' => $this->db->insert_id(), 'user_type' => $this->input->post('user_status'));
                $data_admin = array('phone' => $this->input->post('phone'), 'address' => $this->input->post('address'), 'user_id' => $this->db->insert_id());

                $this->common_model->initialise('user_types');
                $this->common_model->array = $data_usertype;
                $this->common_model->insert_entry();

                $this->common_model->initialise('ichekadmin');
                $this->common_model->array = $data_admin;
                $this->common_model->insert_entry();
            }
        }

        $this->layout->view($this->view_dir, $data);
    }

}
