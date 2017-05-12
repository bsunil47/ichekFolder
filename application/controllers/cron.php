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
class Cron extends My_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function blast() {

        $this->common_model->initialise('blast as B');
        $this->common_model->join_tables = array("followers as F", "users as U");
        $this->common_model->join_on = array("F.id_user = B.user_id", "F.id_follower = U.id");
        $records = $this->common_model->get_records(0, 'F.id_user as merchant_id, U.email, B.message', 'B.datecreated >= DATE_SUB(NOW(), INTERVAL 8 HOUR)');
        //print_r($records); exit;
        foreach ($records as $key => $value) {
            $this->load->model('communication_model');
            $this->communication_model->emailblast($value->merchant_id, $value->email, $value->message);
        }
    }

}
