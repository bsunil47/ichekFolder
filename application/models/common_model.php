<?php

class Common_model extends CI_Model {

    private $table_prefix = 'tbl_';
    public $model_name;
    public $array;
    public $status = 0;
    public $error = array();
    public $join_on;
    public $join_tables;
    public $left_join;

    function __construct() {

        parent::__construct();
    }

    public function initialise($model, $param2 = NULL) {
        unset($this->array);
        unset($this->status);
        unset($error);
        unset($this->join_on);
        unset($this->join_tables);
        $this->model_name = $model;
    }

    //Insert a row to table
    function insert_entry() {
        try {
            $this->db->insert($this->table_prefix . $this->model_name, $this->array);
            return $this->db->insert_id();
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    //Updated a row or rows inside a table
    function update($where) {
        try {
            $this->db->where($where);
            $this->join_tables();
            $this->db->update($this->table_prefix . $this->model_name, $this->array);
            return $report['error'] = $this->db->_error_number();
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    //GET Mulitple recordes use this function
    function get_records($limit, $select, $where, $col = 0, $order = 'desc', $groupby = null, $having = null) {
        try {
            if (!empty($limit)) {
                if (is_array($limit)) {
                    $this->db->limit($limit['limit'], $limit['start']);
                } else {
                    $this->db->limit($limit);
                }
            }
            $this->db->select($select);
            if (!empty($col)) {

                if (is_array($col)) {
                    foreach ($col as $key => $value) {
                        $this->db->order_by($value, $order[$key]);
                    }
                } else {
                    $this->db->order_by($col, $order);
                }
            }
            $this->join_tables();
            if (!empty($where)) {
                //print_r($where);
                $this->db->where($where);
            }
            if (!empty($groupby)) {
                $this->db->group_by($groupby);
            }
            if (!empty($having)) {
                $this->db->having($having);
            }
            $query = $this->db->get($this->table_prefix . $this->model_name);
//            print_r($query);
//            exit;
            return $query->result();
        } catch (Exception $ex) {
            echo $ex;
            exit;
        }
    }

    // Single recod this function
    function get_record_single($where, $select, $groupby = null) {
        try {
            $this->db->select($select);
            $this->join_tables();
            $this->db->where($where);
            if (!empty($groupby)) {
                $this->db->group_by($groupby);
            }
            $query = $this->db->get($this->table_prefix . $this->model_name);
            return $query->row();
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function set_status($where) {
        try {
            $this->db->where($where);
            return $this->db->update($this->table_prefix . $this->model_name, array('status' => $this->status));
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function getLogin() {
        if (!empty($_POST) && $this->loginValidate()) {
            return $this->error;
        } else if (!empty($_POST)) {
            $getval = $this->get_record_single(array("admin_email" => $_POST['email'], "admin_password" => md5($_POST['password'])), "*");

            if (count($getval) > 0) {
                if ($getval->status == 1) {


                    return $getval;
                } else {
                    $this->error['error'] = 'Your account is not activated';
                    $flag = true;
                    return $this->error;
                }
            } else {
                $this->error['error'] = 'The email or password you entered is incorrect';
                $flag = true;
                return $this->error;
            }
        }
    }

    public function loginValidate() {
        $flag = false;
        if (empty($_POST['email'])) {
            $this->error['error']['email'] = 'Please enter Email';
            $flag = true;
        }
        if (empty($_POST['password'])) {
            $this->error['error']['password'] = 'Please enter Password';
            $flag = true;
        }
        if ($flag) {
            return $this->error;
        }
        return $flag;
    }

    public function storeprocedure($callprocedure) {
        try {
            //echo "CALL $callprocedure;"; exit;
            //$this->db->escape_like_str('CALL '.$callprocedure)
            $qry_res = $this->db->query('CALL '.$callprocedure);
            $qry_res->next_result();
            return $res = $qry_res->result();
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function storeprocedureS($procedure,$params) {
        try {
            $string ="";
            //echo "CALL $callprocedure;"; exit;
            foreach($params as $key => $value){

                if(is_numeric($value)){
                    $string .= $value.',';
                }else{
                    if (strpos($value, "'") !== FALSE)
                    $string .= '"'.$this->db->escape_like_str($value).'",';
                    else
                        $string .= '"'.$value.'",';
                }

            }
            $string = trim($string,',');
            //echo 'CALL '.$procedure."($string)";
            $qry_res = $this->db->query('CALL '.$procedure."($string)");
            $qry_res->next_result();
            return $res = $qry_res->result();
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function delete_record() {
        try {
            return $this->db->delete($this->table_prefix . $this->model_name, $this->array);
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    private function join_tables() {
        if (!empty($this->join_on)) {
            if (is_array($this->join_on)) {
                foreach ($this->join_on as $key => $value) {
                    if (!empty($this->left_join[$key])) {
                        $this->db->join($this->table_prefix . $this->join_tables[$key], $value, $this->left_join[$key]);
                    } else {
                        $this->db->join($this->table_prefix . $this->join_tables[$key], $value);
                    }
                }
            } else {
                $this->db->join($this->table_prefix . $this->join_tables, $this->join_on);
            }
        }
    }

    public function insert_batch_entry() {
        try {
            //print_r($this->array);
            $this->db->insert_batch($this->table_prefix . $this->model_name, $this->array);
            return $this->db->insert_id();
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function getTable($aColumns, $where = 0, $col = 0, $order = 'desc', $group_by = null) {
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */

        // DB table to use
        $sTable = $this->table_prefix . $this->model_name;
        //

        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        // Ordering
        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true') {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch)) {
            for ($i = 0; $i < count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }
            //print_r($this->db->ar_like);
        }

        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        if (!empty($where)) {

            $this->db->where($where);
        }
        if (!empty($col)) {

            if (is_array($col)) {
                foreach ($col as $key => $value) {
                    $this->db->order_by($value, $order[$key]);
                }
            } else {
                $this->db->order_by($col, $order);
            }
        }
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }
        $this->join_tables();
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        return $result_array = array('output' => $output, 'result' => $rResult->result_array());
    }

    public function pureQuery($query) {
        $query = $this->db->query($query);
        return $query->result();
    }

    function getUser($get) {
        $sql = $this->db->query('select * from tbl_users as U,tbl_user_types as T,tbl_offerredeemd as R  where U.id = T.user_id and U.id = R.id_merchant and T.user_type=4 and U.firstname like "%' . $get . '%" order by U.firstname asc limit 0,10');
        return $sql->result();
    }

}

?>
