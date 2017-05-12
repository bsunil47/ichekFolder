<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();
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
class General extends My_Controller {

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

    public function faq() {
        $data = array();
        $this->common_model->initialise('general');
        $data['faq'] = $this->common_model->get_records(0, '*', array('type <=' => 1));
        //print_r($data['faq']);
        $data['menuid'] = 'faq';
        $this->layout->view($this->view_dir, $data);
    }

    public function feedback() {
        $data = array();
        $this->common_model->initialise('general as G');
        $this->common_model->join_tables = 'users as U';
        $this->common_model->join_on = "U.id = G.column1";
        $data['feedback'] = $this->common_model->get_records(0, 'U.firstname,U.email,G.general_id,G.column2,G.status', array('G.type ' => 2));
        //print_r($data['feedback']);exit;
        $data['menuid'] = 'feedback';
        $this->layout->view($this->view_dir, $data);
    }

    public function contact() {
        $data = array();
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $data['type'] = 3;
            $data['status'] = 1;
            $this->common_model->initialise('general');
            $this->common_model->array = $data;
            if (!empty($_POST['general_id'])) {
                $where = array('general_id' => $_POST['general_id']);
                $result_update = $this->common_model->update($where);
            } else {
                $id = $this->common_model->insert_entry();
            }
        }
        $this->common_model->initialise('general');
        $data['contact'] = $this->common_model->get_record_single(array('type' => 3), '*');
        $data['menuid'] = 'contact';
        $this->layout->view($this->view_dir, $data);
    }

    public function toucust() {
        $data = array();
        $this->common_model->initialise('general');
        $data['toucustomers'] = $this->common_model->get_records(0, '*', array('type ' => 5));
        $data['menuid'] = 'toucust';
        $this->layout->view($this->view_dir, $data);
    }

    public function toumerchant() {
        $data = array();
        $this->common_model->initialise('general');
        $data['toumerchant'] = $this->common_model->get_records(0, '*', array('type ' => 4));
        $data['menuid'] = 'toumerchant';
        $this->layout->view($this->view_dir, $data);
    }

    public function faqadd() {
        $data = array();
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('question', 'Question', 'required|trim');
        $this->form_validation->set_rules('answer', 'Answer', 'required|trim');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {

                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('column1' => $this->input->post('question'), 'column2' => $this->input->post('answer'), 'type' => $this->input->post('type'), 'status' => 1,);
                $this->common_model->initialise('general');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $this->db->insert_id();
                redirect(base_url() . "Admin/general/faq");
            }
        }
        $data['menuid'] = 'faqadd';
        $this->layout->view($this->view_dir, $data);
    }

    public function contactadd() {
        $data = array();
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]+$/]|trim');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        $this->form_validation->set_message('valid_email', '%s should be an valid email');

        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {

                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('column1' => $this->input->post('email'), 'column2' => $this->input->post('address'), 'column3' => $this->input->post('phone'), 'type' => 3, 'status' => 1);
                $this->common_model->initialise('general');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $this->db->insert_id();
                redirect(base_url() . "Admin/general/contact");
            }
        }
        $data['menuid'] = 'contactadd';
        $this->layout->view($this->view_dir, $data);
    }

    public function toucustadd() {
        $data = array();
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
        $this->form_validation->set_rules('terms', 'Terms', 'required|trim');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {

                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('column1' => $this->input->post('heading'), 'column2' => $this->input->post('terms'), 'type' => 4, 'status' => 1);
                $this->common_model->initialise('general');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $this->db->insert_id();
                redirect(base_url() . "Admin/general/toucust");
            }
        }
        $data['menuid'] = 'toucustadd';
        $this->layout->view($this->view_dir, $data);
    }

    public function toumerchantadd() {
        $data = array();
        $this->load->library('form_validation');
        //set rules here
        $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
        $this->form_validation->set_rules('terms', 'Terms', 'required|trim');
        // set messages
        $this->form_validation->set_message('required', '%s should not be empty');
        if (isset($_POST['submit'])) {
            if ($this->form_validation->run() == FALSE) {

                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            } else {
                $data = array('column1' => $this->input->post('heading'), 'column2' => $this->input->post('terms'), 'type' => 5, 'status' => 1);
                $this->common_model->initialise('general');
                $this->common_model->array = $data;
                $this->common_model->insert_entry();
                $this->db->insert_id();
                redirect(base_url() . "Admin/general/toumerchant");
            }
        }
        $data['menuid'] = 'toumerchantadd';
        $this->layout->view($this->view_dir, $data);
    }

    public function faqstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }
        $data = $statusn;
        $this->common_model->initialise('general');
        $this->common_model->status = $data;
        $where = array('general_id' => $id);
        $this->common_model->set_status($where);
        redirect(base_url() . "Admin/general/faq");
    }

    public function feedbackstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }
        $data = $statusn;
        $this->common_model->initialise('general');
        $this->common_model->status = $data;
        $where = array('general_id' => $id);
        $this->common_model->set_status($where);
        redirect(base_url() . "Admin/general/feedback");
    }

    public function toucuststatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }
        $data = $statusn;
        $this->common_model->initialise('general');
        $this->common_model->status = $data;
        $where = array('general_id' => $id);
        $this->common_model->set_status($where);
        redirect(base_url() . "Admin/general/toucust");
    }

    public function toumerchantstatus($id, $status) {
        //$data = array();
        if ($status == 1) {
            $statusn = 0;
        }
        if ($status == 0 || $status == '' || $status == "NULL") {
            $statusn = 1;
        }
        $data = $statusn;
        $this->common_model->initialise('general');
        $this->common_model->status = $data;
        $where = array('general_id' => $id);
        $this->common_model->set_status($where);
        redirect(base_url() . "Admin/general/toumerchant");
    }

    public function faqedit($id) {
        $data = array();
        $this->common_model->initialise('general');
        $data['faq'] = $this->common_model->get_record_single(array('general_id' => $id), 'column1,column2, type');
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('general');
            $this->common_model->array = $data;
            $where = array('general_id' => $id);
            $result_update = $this->common_model->update($where);
            $data['faq'] = $this->common_model->get_record_single(array('general_id' => $id), 'column1,column2');
            //redirect(base_url() . "Admin/general/faqedit/$id");
            redirect(base_url() . "Admin/general/faq");
        }
        $data['menuid'] = 'faq';
        $this->layout->view($this->view_dir, $data);
    }

    public function toucustedit($id) {//echo "hi";
        $data = array();
        $this->common_model->initialise('general');
        $data['toucust'] = $this->common_model->get_record_single(array('general_id' => $id), 'column1,column2');
        //print_r($data['toucust']);
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('general');
            $this->common_model->array = $data;
            $where = array('general_id' => $id);
            $result_update = $this->common_model->update($where);
            $data['toucust'] = $this->common_model->get_record_single(array('general_id' => $id), '*');
            //redirect(base_url() . "Admin/general/toucustedit/$id");
            redirect(base_url() . "Admin/general/toucust");
        }
        $data['menuid'] = 'toucust';
        $this->layout->view($this->view_dir, $data);
    }

    public function toumerchantedit($id) {

        $data = array();
        $this->common_model->initialise('general');
        $data['toumerchant'] = $this->common_model->get_record_single(array('general_id' => $id), '*');
        //update query
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $this->common_model->initialise('general');
            $this->common_model->array = $data;
            $where = array('general_id' => $id);
            $result_update = $this->common_model->update($where);
            $data['toumerchant'] = $this->common_model->get_record_single(array('general_id' => $id), '*');
            // redirect(base_url() . "Admin/general/toumerchantedit/$id");
            redirect(base_url() . "Admin/general/toumerchant");
        }
        $data['menuid'] = 'toumerchant';
        $this->layout->view($this->view_dir, $data);
    }

    public function proximal() {
        $data = array();
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            $data['type'] = 6;
            $data['status'] = 1;
            $this->common_model->initialise('general');
            $this->common_model->array = $data;
            if (!empty($_POST['general_id'])) {
                $where = array('general_id' => $_POST['general_id']);
                $result_update = $this->common_model->update($where);
            } else {
                $id = $this->common_model->insert_entry();
            }
        }
        $this->common_model->initialise('general');
        $data['contact'] = $this->common_model->get_record_single(array('type' => 6), '*');
        $data['menuid'] = 'proximal';
        $this->layout->view($this->view_dir, $data);
    }

}
