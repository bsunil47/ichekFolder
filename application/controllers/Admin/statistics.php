<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Statistics
 *
 * @author Kesav
 */
class Statistics extends My_Controller {

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
        $data['menuid'] = 'statistics_redeem';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getData() {
        $aColumns = array('R.id', 'display_name', 'name', 'count(R.id_offer)');
        $this->common_model->initialise('merchant as M');
        $this->common_model->join_tables = array('offers as O', 'offerredeemd as R');
        $this->common_model->join_on = array('M.user_id = O.user_id', 'O.id = R.id_offer');
        $where = array('O.status !=' => 0, 'O.status !=' => "NULL");
        $groupby = array('R.id_offer');
        //$order = array('total' => 'desc');
        $data = $this->common_model->getTable($aColumns, $where, 'count(R.id_offer)', $order = 'desc', $groupby);
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'R.');
                $row[] = $aRow[$col];
            }
            $row[0] = $j;
            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function activeusers() {
        $data = array();
        $data['menuid'] = 'statistics_active';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getDataactive() {
        $aColumns = array('R.id', 'firstname', 'count(R.id_customer)');
        $this->common_model->initialise('users as U');
        $this->common_model->join_tables = array('offers as O', 'offerredeemd as R');
        $this->common_model->join_on = array('U.id = O.user_id', 'O.id = R.id_offer');
        $where = array('O.status !=' => 0, 'O.status !=' => "NULL");
        $groupby = array('U.id');
        $data = $this->common_model->getTable($aColumns, $where, $col = 'count(id_customer)', $order = 'desc', 'U.id');
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'R.');
                $row[] = $aRow[$col];
            }
            $row[0] = $j;

            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function activeoffers() {
        $data = array();
        $data['menuid'] = 'statistics_active_merchants';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function getDataactivemerchants() {
        $aColumns = array('R.id', 'business_name', 'count(M.user_id)');
        $this->common_model->initialise('merchant as M');
        $this->common_model->join_tables = array('offers as O', 'offerredeemd as R');
        $this->common_model->join_on = array('M.user_id = O.user_id', 'O.id = R.id_offer');
        $where = array('O.status !=' => 0, 'O.status !=' => "NULL");
        $groupby = 'R.id_merchant';
        $data = $this->common_model->getTable($aColumns, $where, $col = 0, $order = 'desc', $groupby);
        $output = $data['output'];
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $col = trim($col, 'R.');
                $row[] = $aRow[$col];
            }
            $row[0] = $j;

            $j = $j + 1;
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function sorting() {//echo "hi";exit;
        $data = array();
        $data['menuid'] = 'statistics_sort';
        $data['admin_url'] = $this->admin_base_url;
        $this->layout->view($this->view_dir, $data);
    }

    public function sortingdata() {
        $data = array();
        if (!empty($_POST)) {
            $dt = new DateTime($_POST['fromdate']);
            $from_date = $dt->format("Y-m-d");
            $dtt = new DateTime($_POST['todate']);
            $to_date = $dtt->format("Y-m-d");
            if ($_POST['sorttype'] == 5) {
                $data['sortname'] = "Merchant";
            } elseif ($_POST['sorttype'] == 4) {
                $data['sortname'] = "customer";
            } elseif ($_POST['sorttype'] == 2) {
                $data['sortname'] = "Category";
            } else {
                $data['sortname'] = "All";
            }
            $data['results'] = $_POST;
            $data['results']['frmdate'] = $from_date;
            $data['results']['tdate'] = $to_date;
            unset($data['results']['fromdate']);
            unset($data['results']['todate']);
            $data['menuid'] = 'statistics_sort';
            $data['admin_url'] = $this->admin_base_url;
            $this->layout->view($this->view_dir, $data);
        }
    }

    public function getsortingdata() {
        $date = date("Y-m-d");
        $data = array();
        $join_on = array();
        if (!empty($_POST)) {
            $data = $_POST;
            unset($data['submit']);
            if ($data['from_date'] != $date) {
                $from = $data['from_date'];
                $to = $data['to_date'];
                if (empty($data['sort_type'])) {
                    $where = "R.datecreated between '" . $from . "' and '" . $to . "'";
                    $groupby = array('R.id_offer');
                } else if ($data['sort_type'] == 'all') {
                    $where = "R.datecreated between '" . $from . "' and '" . $to . "'";
                    $groupby = array('R.id_offer');
                } else if ($data['sort_type'] == 5) {
                    $where = "R.datecreated between '" . $from . "' and '" . $to . "' and R.id_customer = '" . $data['user_id'] . "'";
                    $groupby = array('R.id_customer', 'R.id_offer');
                } else if ($data['sort_type'] == 4) {
                    $where = "R.datecreated between '" . $from . "' and '" . $to . "' and R.id_merchant = '" . $data['user_id'] . "'";
                    $groupby = array('R.id_merchant', 'R.id_offer');
                } else if ($data['sort_type'] == 2) {
                    $this->common_model->initialise('categories');
                    $category = $this->common_model->get_record_single("id = " . $data['user_id'], '*');
                    $where = "R.datecreated between '" . $from . "' and '" . $to . "' and OF.category_type like ('%" . $category->name . "%')";
                    $groupby = array('OF.category_type', 'R.id_offer');
                }
                //               $order = array('total' => 'desc');
            }//TIMEPERIOD
            else {
                if ($data['sort_type'] == 'all') {
                    $where = '';
                    $groupby = array('R.id_offer');
                }
                if ($data['sort_type'] == 5) {
                    $where = "R.id_customer = '" . $data['user_id'] . "'";
                    $groupby = array('R.id_customer', 'R.id_offer'); //array('R.id_customer'=>$data['user_id']);
                } else if ($data['sort_type'] == 4) {
                    $where = "R.id_merchant = '" . $data['user_id'] . "'";
                    $groupby = array('R.id_merchant', 'R.id_offer'); //array('R.id_merchant' => $data['merchant_id']);
                } else if ($data['sort_type'] == 2) {
                    $this->common_model->initialise('categories');
                    $category = $this->common_model->get_record_single("id = " . $data['user_id'], '*');
                    $where = "OF.category_type like '%" . $category->name . "%'";
                    $groupby = array('OF.category_type', 'R.id_offer');
                }
            }//else
            $this->common_model->initialise('offerredeemd as R');
            $this->common_model->join_tables = array('offers as OF', 'merchant as M');
            $join_on[] = 'OF.id = R.id_offer';
            $join_on[] = 'R.id_merchant  = M.user_id';
            $this->common_model->join_on = $join_on;
            $aColumnss = array('name', 'display_name', 'category_type', 'count');
            $aColumns = array('OF.name', 'M.display_name', 'OF.category_type', 'count(R.id_offer) as count');
            $data = $this->common_model->getTable($aColumns, $where, 'R.datecreated', $order = 'desc', $groupby);
            $output = $data['output'];
        }//POST
        $j = $this->input->get_post('iDisplayStart', true) + 1;
        foreach ($data['result'] as $aRow) {
            $row = array();
            foreach ($aColumnss as $col) {
                $row[0] = $j;
                $col = trim($col, 'R.');
                $row[] = $aRow[$col];
            }
            $j = $j + 1;
            if (end($row) != 0) {
                $output['aaData'][] = $row;
            } else {
                unset($outout);
            }
        }
        echo json_encode($output);
    }

    public function getFilterData() {
        if (!empty($_POST['term']))
            $term = $_POST['term'];
        $data = array();
        $join_on = array();
        $this->common_model->initialise('offerredeemd as R');
        if ($_POST['type'] == 5 || $_POST['type'] == 4) {
            $sort_type = $_POST['type'];
            $this->common_model->join_tables = array('offers as OF', 'users as U', 'user_types as T');
            $join_on[] = 'OF.id = R.id_offer';
            if ($_POST['type'] == 4) {
                $join_on[] = 'U.id = OF.user_id';
                $join_on[] = 'OF.user_id = T.user_id';
            } else {
                $join_on[] = 'U.id = R.id_customer';
                $join_on[] = 'R.id_customer = T.user_id';
            }
            $this->common_model->join_on = $join_on;
            $where = "T.user_type = $sort_type  AND (U.firstname like '%$term%')";
            $rows = $this->common_model->get_records(0, 'U.firstname,U.id', $where, 0, 'desc', 'U.id');
            foreach ($rows as $row) {
                $data[] = array(
                    'value' => $row->firstname, 'id' => $row->id);
            }
        }
        if ($_POST['type'] == 2) {
            $query = "SELECT `C`.`name`, `C`.`id` FROM (`tbl_offerredeemd` as R) JOIN `tbl_offers` as O ON `O`.`id` = `R`.`id_offer`
JOIN `tbl_categories` as C ON `O`.`category_type` like concat('%',C.name,'%') WHERE `C`.`name` like '%$term%'
GROUP BY C.name";
            $rows = $this->common_model->pureQuery($query);
            foreach ($rows as $row) {
                $data[] = array('value' => $row->name, 'id' => $row->id);
            }
        }
        echo json_encode($data);
        flush();
    }

}
