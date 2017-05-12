<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
class Frontend extends My_Controller {

    //put your code here
    public function __construct() {
        $allowed_methodes = array('index', 'changepassword', 'merchant', 'faq', 'tou', 'appinfo', 'contactus', 'feedback', 'privacy', 'aboutus');
        parent::__construct();
        if (!in_array($this->router->fetch_method(), $allowed_methodes) && !$this->_is_home_logged_in()) {

            redirect(base_url());
        }

        $this->view_dir = $this->router->fetch_class() . '/' . $this->router->fetch_method();
        $this->layout->setLayout('main.php');
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
                    $result_s = $this->common_model->get_record_single(array('user_id' => $result->id, 'user_type =' => 4), '*');
                    if (!empty($result_s)) {
                        $this->session->set_userdata('user_id', $result->id);
                        /* $this->session->set_userdata('firstname', $result->firstname);
                          $this->session->set_userdata('lastname', $result->lastname);
                          $this->session->set_userdata('email', $result->email);
                          $this->session->set_userdata('user_type', $result_s->user_type); */
                        redirect(base_url() . 'merchants/index');
                    } else {
                        $this->setFlashmessage('error', 'Not able to login');
                        redirect(base_url());
                    }
                } else {
                    $this->setFlashmessage('error', 'Invalid Username or Password');
                    redirect(base_url());
                }
            }
        }
        $this->layout->setLayout('merchants_login');
        $this->layout->view($this->view_dir, $data);
    }

    public function changepassword($id) {
        $data = array();
        $this->common_model->initialise('hashurl');
        $data_array = $this->common_model->get_record_single(array('hashcode' => $id), '*');
        if (!empty($_POST) && !empty($_POST['password']) && !empty($_POST['c_password']) && $data_array->status == 0) {
            $this->common_model->initialise('users');
            $this->common_model->array = array('password' => $_POST['password']);
            if (!$this->common_model->update(array('id' => $data_array->user_id))) {
                $data['success'] = 'Successfully Changed password';
                $this->common_model->initialise('hashurl');
                $this->common_model->array = array('status' => 1);
                $this->common_model->update(array('hashcode' => $id));
            }
        } elseif (empty($data_array)) {
            show_404();
        } else {
            if ($data_array->status == 1) {
                $data['error'] = 'Already used this link';
            } else {
                $data['error'] = 'please fill necessary feilds';
            }
        }
        $this->layout->setLayout('password');
        $this->layout->view($this->view_dir, $data);
    }

    public function merchant($id) {
        $data = array();
        $this->common_model->initialise('hashurl');
        $data_array = $this->common_model->get_record_single(array('hashcode' => $id), '*');
        if (!empty($_POST) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && ($data_array->status == 0 && ($data_array->type == 4 || $data_array->type == 5))) {
            $user = $this->check_user(array('email' => $_POST['email']));
            if (empty($user)) {
                $user_arry = $_POST;
                unset($user_arry['location']);
                unset($user_arry['submit']);
                $this->common_model->initialise('users');
                $this->common_model->array = $this->trim_addslashes($user_arry);
                $user_id = $this->common_model->insert_entry();
                if (!empty($user_id)) {
                    if ($data_array->type == 4) {
                        $this->common_model->initialise('invitebusiness');
                        $business = $this->common_model->get_record_single(array('business_invite_id' => $data_array->user_id), '*');
                        $bussiness_id = $business->business_id;
                        $this->common_model->initialise('business');
                        $business_details = $this->common_model->get_record_single(array('id' => $business->business_id), 'title, info_short, url, address, city, state, pincode, phone, mobile, fax, passcode, paypalid, business_name, category, lat ,lng');
                    } else {
                        $business_details = null;
                        $bussiness_id = null;
                    }
                    $location = $_POST['location'];
                    $this->insert_user_type(4, $user_id, $location, $business_id, $business_details);
                    $data['success'] = 'Successfully added record';
                    $this->common_model->initialise('hashurl');
                    $this->common_model->array = array('status' => 1);
                    $this->common_model->update(array('hashcode' => $id));
                    if ($data_array->type == 4) {
                        $this->common_model->initialise('invitebusiness');
                        $this->common_model->array = array('status' => 2);
                        $this->common_model->update(array('business_invite_id' => $data_array->user_id));
                    }
                }
            } else {
                $data['error'] = 'This Email is already in use in Ichek';
            }
        } elseif (empty($data_array)) {
            show_404();
        } else {
            if ($data_array->status == 1) {
                $data['error'] = 'Already used this link';
            } else {
                $data['error'] = 'please fill necessary feilds';
            }
        }
        $this->layout->setLayout('password');
        $this->layout->view($this->view_dir, $data);
    }

    public function faq($type = 5) {
        if($type == 4){
            $type = 0;
        }else{
            $type = 1;
        }
        $data = array();
        $this->common_model->initialise('general');
        $data['faq'] = $this->common_model->get_records(0, '*', array('type' => $type, 'status' => 1));
        $this->layout->setLayout('mobile');
        $this->layout->view($this->view_dir, $data);
    }

    public function tou($type) {
        $data = array();
        $this->common_model->initialise('general');
        $data['tou'] = $this->common_model->get_records(0, '*', array('type' => $type, 'status' => 1));
        $this->layout->setLayout('mobile');
        $this->layout->view($this->view_dir, $data);
    }

    public function appinfo() {
        $this->layout->setLayout('mobile');
        $this->layout->view($this->view_dir);
    }

    public function contactus() {
        $data = array();
        $this->common_model->initialise('general');
        $data['contact'] = $this->common_model->get_records(0, '*', array('type' => 3, 'status' => 1));
        // echo "<pre>";
        // print_r($data);exit;
        $this->layout->setLayout('mobile');
        $this->layout->view($this->view_dir, $data);
    }

    public function privacy() {
        $this->layout->setLayout('mobile');
        $this->layout->view($this->view_dir);
    }

    public function aboutus() {
        $this->layout->setLayout('mobile');
        $this->layout->view($this->view_dir);
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        redirect($this->admin_base_url);
    }

}
