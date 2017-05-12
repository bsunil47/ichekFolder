<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of API
 * This give webservice for login,signup forgot password and new password for mobile application
 * @author kesav
 */
class APIMERCHANT extends My_Controller {

    //put your code here
    public $login_error = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }

    /*
     * Merchant Details
     *
     */

    public function details($id) {

        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['response'] = FALSE;
        $merchant = $this->common_model->storeprocedure("MerchantDetails({$id})");
        if (!empty($merchant)) {
            $data['response'] = TRUE;
            $merchant = $data['info']['merchant'] = $merchant[0];
            $this->common_model->initialise('business_hours');
            $business_hours = $this->common_model->get_records(0, array("*", "DATE_FORMAT(start_time, '%H:%i') as start_time", "DATE_FORMAT(end_time, '%H:%i') as end_time"), $where = array('user_id' => $id));
            if (!empty($business_hours)) {
                $data['info']['business_hours'] = $this->common_model->get_records(0, array("*", "DATE_FORMAT(start_time, '%H:%i') as start_time", "DATE_FORMAT(end_time, '%H:%i') as end_time"), $where = array('user_id' => $id));
            } else {
                $data['info']['business_hours'] = array(array('error' => 'false'));
            }
            $this->common_model->initialise('points_status');
            $status = $this->common_model->get_records('1', 'name', $where = array('points <=' => $merchant->points), $col = 'points', $order = 'desc');
            $data['info']['user_status'] = 'New';
            if (!empty($status)) {
                $data['info']['user_status'] = $status[0]->name;
            }
            //get most redeemed customers
            $this->common_model->initialise('offerredeemd');
            $select = array('id_customer', 'count(*) as count');
            $result = $this->common_model->get_records(2, $select, array('id_merchant' => $id), 'count', 'desc', 'id_customer');
            if (!empty($result)) {
                $ids = implode(',', array_map('current', $result));
                $this->common_model->initialise('users');
                $where = "id IN ($ids)";
                $select = array("CONCAT(firstname, ' ', lastname) as firstlast");
                $result = $this->common_model->get_records(2, $select, $where);
                $data['info']['most_redeemed_customers'] = $result;
                $this->common_model->initialise('offerreviews as OFR');
                $this->common_model->join_tables = array('offers as OF');
                $this->common_model->join_on = array("OF.id = OFR.id_offer");
                $where = array('OF.user_id' => $id);
                $select = array('avg(rating) as avg', 'count(rating) as count');
                $result = (array) $this->common_model->get_records(1, $select, $where, 'avg', 'desc', 'OF.user_id');
                $data['info']['merchant_rating'] = $result[0];
            }
            //total number of customers
            $this->common_model->initialise('offerredeemd as OFD');
            $this->common_model->join_tables = array('customer as C');
            $this->common_model->join_on = array("OFD.id_customer = C.user_id");
            $row = $this->common_model->get_records(0, array('count(*) as count'), array('OFD.id_merchant' => $id), 'count', 'desc', 'OFD.id_customer');
            $data['info']['total_customers'] = count($row);
            $this->common_model->initialise('followers');
            $followers = $this->common_model->get_record_single("id_user = $id", 'count(id) as count');
            $data['info']['followers_count'] = $followers->count;
            $data['info']['graph_values'] = $this->common_model->storeprocedure("MerchantCashback({$id})");
        } else {
            $this->api_model->response('', 406);
        }
        $output = $this->api_model->json($data);
        $this->log($id, array($id, 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    //Update User Details-basic
    public function edit() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['response'] = False;
        $required_feilds = array('business_name', 'display_name', 'location', 'mobile');
        if (empty($_POST) && empty($_FILES)) {
            $data['error'] = 'In suffecient data';
        } else {
            if (!empty($_POST)) {
                foreach ($required_feilds as $key => $value) {
                    if (empty($_POST[$value])) {
                        $data['error'][$value] = "$value should not be empty";
                    } elseif ($value == 'business_name' || $value == 'display_name') {
                        $data_array[$value] = ucwords(mysqli_real_escape_string($_POST[$value]));
                        //($this->alph_check($_POST[$value]) === false ) ? $data['error'][$value] = "please enter alphabets only for $value" : $data_array[$value] = ucwords($_POST[$value]);
                    } else {
                        $data_array[$value] = urldecode($_POST[$value]);
                    }
                }//foreach
                if (empty($data['error'])) {
                    $data_array['url'] = $_POST['url'];
                    $data_array['fax'] = $_POST['fax'];
                    $data_array['phone'] = $_POST['phone'];
                    $data_array['facebook_page_id'] = $_POST['facebook_page_id'];
                    $data_array['facebook_page_name'] = $_POST['facebook_page_name'];
                    $data_array['search_column'] = mysqli_real_escape_string($_POST['display_name']).' , '.mysqli_real_escape_string($_POST['business_name']);
                    $this->common_model->initialise('merchant');
                    $data_array = $this->trim_addslashes($data_array);
                    $data_array['business_name'] = ucwords($_POST['business_name']);
                    $data_array['display_name'] = ucwords($_POST['display_name']);
                    $this->common_model->array = $data_array;
                    if ($this->common_model->update(array('user_id' => $_POST['user_id'])) == 0) {
                        $data['response'] = TRUE;
                        $data['info']['message'] = 'Updated Successfully';
                        //$data['info']['login_status'] = 2;
                }
                    $user_id = $_POST['user_id'];
                    $select_query = "SELECT CONCAT_WS(',',display_name, business_name, address,location, city, title, category) as search_column FROM tbl_merchant WHERE user_id = {$_POST['user_id']}";
                    $search_col = $this->common_model->pureQuery($select_query);
                    $data_arr['search_column'] = $search_col[0]->search_column;
                    $this->common_model->initialise('merchant');
                    $this->common_model->array = $data_arr;
                    $this->common_model->update(array('user_id' => $_POST['user_id']));
                    /*;
                    $search_col = $_POST['display_name'].' , '.$_POST['business_name'];
                    $query = "UPDATE tbl_merchant SET search_column = $search_col WHERE user_id = $user_id";
                    $this->common_model->pureQuery($query);*/
                } else {
                    $data['message'] = 'In suffecient data';
                }
            }
            if (!empty($_FILES)) {
                $target_dir = FCPATH . "uploads/";
                if (!is_dir($target_dir . $_POST['user_id'])) {
                    mkdir($target_dir . $_POST['user_id'], 0777, true);
                }
                foreach ($_FILES as $key => $value) {
                    $allwoed_extentions = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
                    $target_file = $target_dir . $_POST['user_id'] . '/' . basename($_FILES[$key]["name"]);
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    if (!in_array($imageFileType, $allwoed_extentions)) {
                        $data['error'] = 'Problem with Upload data';
                    } else {
                        if (move_uploaded_file($_FILES[$key]["tmp_name"], $target_file)) {
                            $this->common_model->initialise('merchant');
                            $this->common_model->array = array($key => basename($_FILES[$key]["name"]));
                            $where = array('user_id' => $_POST['user_id']);
                            if (!$this->common_model->update($where)) {
                                $data['info']['message'] = 'Action completed successfully';
                            }
                        } else {
                            $data['error'] = 'Problem with Upload';
                        }
                    }
                }
            }
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    //Update Account details-address
    public function update_address() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['response'] = False;
        $required_feilds = array('info_short', 'state', 'city', 'pincode', 'address');
        if (!empty($_POST)) {
            foreach ($required_feilds as $key => $value) {
                if (empty($_POST[$value])) {
                    $data['error'][$value] = "$value should not be empty";
                } elseif ($value == 'state' || $value == 'city') {
                    ($this->alph_check($_POST[$value]) === false ) ? $data['error'][$value] = "please enter alphabets only for $value" : $data_array[$value] = ucwords($_POST[$value]);
                } elseif ($value == 'pincode') {
                    /* if (!preg_match("/^[0-9-]{6,16}+$/", $_POST[$value])) {
                      $data['error'][$value] = "Please enter valid $value number";
                      } */
                    $data_array[$value] = $_POST[$value];
                } else {
                    $data_array[$value] = $_POST[$value];
                }
            }//foreach
            if (empty($data['error'])) {
                $data_array['address2'] = $_POST['address2'];
                $data_array['lat'] = $_POST['lat'];
                $data_array['lng'] = $_POST['lng'];
                $this->common_model->initialise('merchant');
                $this->common_model->array = $this->trim_addslashes($data_array);
                if ($this->common_model->update(array('user_id' => $_POST['user_id'])) == 0) {
                    $this->common_model->initialise('users');
                    $this->common_model->array = array('login_status' => '2');
                    $this->common_model->update(array('id' => $_POST['user_id']));
                    $data['response'] = TRUE;
                    $data['info']['message'] = 'Updated Successfully';
                }
                $user_id = $_POST['user_id'];
                $select_query = "SELECT CONCAT_WS(',',display_name, business_name, address,location, city, title, category) as search_column FROM tbl_merchant WHERE user_id = {$_POST['user_id']};";
                $search_col = $this->common_model->pureQuery($select_query);
                $data_arr['search_column'] = $search_col[0]->search_column;
                $this->common_model->initialise('merchant');
                $this->common_model->array = $data_arr;
                $this->common_model->update(array('user_id' => $_POST['user_id']));
            } else {
                $data['message'] = 'In suffecient data';
            }
        } else {
            $this->api_model->response('', 204);
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

//Add/Update business_hours
    public function business_hours_images() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['response'] = False;
        if (empty($_POST['business_hours']) && empty($_FILES)) {
            $data['error'] = 'In suffecient data';
        } else {
            if (!empty($_POST['business_hours'])) {
                $arr = $this->bussiness_hours(json_decode(utf8_encode(urldecode($_POST['business_hours']))), $_POST['user_id']);
                if ($this->flag) {
                    $data['error'] = 'Problem with data';
                } else {
                    $data['response'] = True;
                    $data['info']['message']['business_hours'] = "Action completed sucessfully";
                }
            }
            if (!empty($_FILES)) {
                //print_r($_FILES);
                $target_dir = FCPATH . "uploads/";
                if (!is_dir($target_dir . $_POST['user_id'])) {
                    mkdir($target_dir . $_POST['user_id'], 0777, true);
                }
                foreach ($_FILES as $key => $value) {
                    $target_file = $target_dir . $_POST['user_id'] . '/' . basename($_FILES[$key]["name"]);
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
                        $data['error'] = 'Problem with Upload data';
                    } else {
                        if (move_uploaded_file($_FILES[$key]["tmp_name"], $target_file)) {
                            $this->common_model->initialise('merchant');
                            $this->common_model->array = array($key => basename($_FILES[$key]["name"]));
                            $where = array('user_id' => $_POST['user_id']);
                            if (!$this->common_model->update($where)) {
                                $data['response'] = True;
                                $data['info']['message']['images'] = 'Action completed successfully';
                            }
                        } else {
                            $data['error'] = 'Problem with Upload';
                        }
                    }
                }
            }
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function get_balance($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $row = $this->check_user(array('id' => $id), 'cash');
        $value = $this->ichecksettings();
        $data['info']['response'] = TRUE;
        $data['info']['paypal_balance'] = $row->cash;
        $data['info']['cpc'] = $value->cpc;
        $data['info']['icheksetting_id'] = $value->icheksetting_id;
        $data['info']['cashout_min_points'] = $value->cashout_min_points;
        $data['info']['max_cash_out'] = $value->max_cash_out;
        $data['info']['cash_out_fee'] = $value->cash_out_fee;
        $data['info']['max_cash_out_fee'] = $value->max_cash_out_fee;
        $output = $this->api_model->json($data);
        $this->log($id, array($id, 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    /*
     * Merchant Function end
     */
    /*
     * Offers start
     */

    //Add Offer
    public function add_offer() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $required_feilds = array('category', 'cashback', 'name',/* 'terms',*/ 'qty_available', 'qty_perperson', 'user_id', 'balance_required');
        if (!empty($_POST)) {
            foreach ($required_feilds as $key => $value) {
                if (empty($_POST[$value])) {
                    $data['error'][$value] = "$value should not be empty";
                } elseif ($value == 'name') {
                    $data_array[$value] = $_POST[$value];
                } else {
                    if (($value == 'cashback' || $value == 'qty_available' || $value == 'qty_perperson') && !is_numeric($_POST[$value])) {
                        $data['error'][$value] = "Please enter numbers only";
                    } else {
                        $data_array[$value] = $_POST[$value];
                    }
                }
            }//foreach
            $terms = "";
            $act_terms ="";
            if(!empty($_POST['terms'])){
                $terms = ", {$_POST['terms']}";
                $act_terms = "{$_POST['terms']}";
            }
            $data_array['info'] = '$' . $_POST['cashback'] . ' Off' . $terms;
            if (empty($data['error'])) {
                if ($_POST['expirydate'] == 'Never') {
                    $data_array['expirydate'] = "0000-00-00 00:00:00";
                } else {
                    $data_array['expirydate'] = $_POST['expirydate'];
                }
                if (!empty($_POST['category_type'])) {
                    $data_array['category_type'] = $_POST['category_type'];
                }
                $cpc = $this->ichecksettings();
                $data_array['icheksettings_id'] = $cpc->icheksetting_id;
                $this->common_model->initialise('offers');
                $this->common_model->array = $this->trim_addslashes($data_array);
                if ($last_id = $this->common_model->insert_entry()) {
                    $user_details = $this->check_user(array('id' => $_POST['user_id']), 'cash');
                    $this->cashupdate($_POST['user_id'], $user_details->cash - $_POST['balance_required']);
                    $data['info']['response'] = TRUE;
                    $this->common_model->initialise('merchant');
                    $row = $this->common_model->get_record_single(array('user_id' => $_POST['user_id'], 'passcode' => NULL), 'COUNT(*) as count');
                    ($row->count != 0) ? ($data['info']['offer_status'] = 0) : $data['info']['offer_status'] = 1;
                    $points = $this->get_points($this->router->fetch_method());
                    $this->pointsforactivities(array("$points->activity_name: $ " . number_format($_POST['cashback'], 2) . " Off ", $act_terms), $last_id, $points->id, $points->activity_points, $users = array('id_customer' => 0, 'id_merchant' => $_POST['user_id']));
                    $data['info']['message'] = 'Offer added successfully';
                    $this->send_push($_POST['user_id'], 'Added Offer', $custom = array('offer_id' => $last_id));
                }
            }
        } else {
            $this->api_model->response('', 204);
        }
        $output = $this->api_model->json($data);
        $this->log($_POST['user_id'], array($_POST['user_id'], 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function update_offer() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $required_feilds = array('category', 'cashback', 'name', /*'terms',*/ 'qty_available', 'qty_perperson', 'balance_required');
        if (!empty($_POST)) {
            foreach ($required_feilds as $key => $value) {
                if (empty($_POST[$value])) {
                    $data['error'][$value] = "$value should not be empty";
                } elseif ($value == 'name') {
                    /* if(!preg_match("/^[a-zA-Z ]+$/", $_POST[$value])){
                      $data['error'][$value] = "please enter alphabets only for $value";
                      }else{ */
                    $data_array[$value] = $_POST[$value];
                    //}
                } elseif ($value == 'cashback' || $value == 'qty_available' || $value == 'qty_perperson') {
                    if (!is_numeric($_POST[$value])) {
                        $data['error'][$value] = "Please enter numbers only";
                    } else {
                        $data_array[$value] = $_POST[$value];
                    }
                } else {
                    $data_array[$value] = $_POST[$value];
                }
            }//foreach
            $terms = "";
            $act_terms ="";
            if(!empty($_POST['terms'])){
                $terms = ", {$_POST['terms']}";
                $act_terms = "{$_POST['terms']}";
                $data_array['terms'] = $_POST['terms'];
            }

            $data_array['info'] = '$' . $_POST['cashback'] . ' Off ' . $terms;
            if (empty($data['error'])) {
                if ($_POST['expirydate'] == 'Never') {
                    $data_array['expirydate'] = "0000-00-00 00:00:00";
                } else {
                    $data_array['expirydate'] = $_POST['expirydate'];
                }
                if (!empty($_POST['category_type'])) {
                    $data_array['category_type'] = $_POST['category_type'];
                }
                $this->common_model->initialise('offers');
                $data_array['datemodified'] = date('Y-m-d');
                $this->common_model->array = $this->trim_addslashes($data_array);
                if ($this->common_model->update(array('id' => $_POST['offer_id'])) == 0) {
                    $merchant_id = $this->common_model->storeprocedure("MerchantOfferDetails({$_POST['offer_id']},{$_POST['user_id']})"); //$this->offerdetails($_POST['offer_id']);
                    $merchant_id = $merchant_id[0];
                    $points = $this->get_points($this->router->fetch_method());
                    $this->pointsforactivities(array("$points->activity_name: $" . number_format($_POST['cashback'], 2) . " Off ", $act_terms), $_POST['offer_id'], $points->id, $points->activity_points, $users = array('id_customer' => 0, 'id_merchant' => $_POST['user_id']));
                    $user_details = $this->check_user(array('id' => $merchant_id->user_id), 'cash');
                    if (!empty($_POST['amount_type']) && $_POST['amount_type'] == 1) {
                        $data['info']['y_amount'] = $user_details->cash;
                        $data['info']['amount'] = $_POST['amount_merchant'];
                        $this->cashupdate($merchant_id->user_id, $user_details->cash + $_POST['amount_merchant']);
                    } elseif (!empty($_POST['amount_type']) && $_POST['amount_type'] == 2) {
                        $this->cashupdate($merchant_id->user_id, $user_details->cash - $_POST['amount_merchant']);
                        $data['info']['y_amount'] = $user_details->cash;
                        $data['info']['amount'] = $_POST['amount_merchant'];
                    }
                    $data['info']['response'] = TRUE;
                    $data['info']['message'] = 'Offer updated successfully';
                }
            }
            $this->send_push($merchant_id->user_id, 'Edited Offer', $custom = array('offer_id' => $_POST['offer_id']));
            $this->log($merchant_id->user_id, array($merchant_id->user_id, 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $this->api_model->json($data)));
        } else {
            $this->api_model->response('', 204);
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

//Get Offers
    public function get_offers($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('offers');
        $select = array('id', "DATE_FORMAT(datecreated,'%e') as day", "DATE_FORMAT(datecreated,'%b %y') as monthyear, CASE WHEN expirydate IN ('0000-00-00 00:00:00') THEN 'Never'
         ELSE expirydate END AS expirydate", 'info');
        $data['info'] = $this->common_model->get_records(100, $select, "user_id = $id AND status = '1'", 'datecreated', $order = 'desc');
        if (!empty($data['info'])) {
            $data['response'] = TRUE;
        } else {
            $data['response'] = FALSE;
            $data['info']['message'] = 'No offers found';
        }
        $output = $this->api_model->json($data);
        $this->log($id, array($id, 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function offerdetails($id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['response'] = FALSE;
        $this->common_model->initialise('merchant');
        $where = array('user_id' => $_POST['user_id']);
        $data['info']['merchant'] = $this->common_model->get_record_single($where, "*");
        if (!empty($data['info']['merchant'])) {
            $offer_data = $this->common_model->storeprocedure("MerchantOfferDetails({$id},{$_POST['user_id']})");
            if (!empty($offer_data)) {
                $data['response'] = true;
                $data['info']['offer_data'] = (array) $offer_data[0];
                $data['info']['offer_data']['reddemed_count'] = $this->reedemed_count($id);
                $this->common_model->initialise('customersavedoffers');
                $wher['id_offer'] = $id;
                $saved = $this->common_model->get_record_single($wher, "COUNT(id_offer) as count");
                $data['info']['offer_data']['saved_count'] = $saved->count;
            } else {
                $data['error'] = "offer dont exist";
            }
        } else {
            $data['error'] = "Merchant dont exist";
        }
        $output = $this->api_model->json($data);
        $this->log($_POST['user_id'], array($_POST['user_id'], $this->router->fetch_method(), 'merchant', date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function delete_offer($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $this->common_model->initialise('offers');
        $this->common_model->status = 0;
        $where = array('id' => $id);
        $row = $this->common_model->set_status($where);
        $offer = $this->common_model->get_record_single($where, "*");
        $redeem_count = $this->reedemed_count($id);
        $user = $this->check_user(array('id' => $offer->user_id));
        $cpc = $this->ichecksettings($offer->icheksettings_id);
        $amount = (($offer->cashback * $offer->qty_available) + (($offer->cashback * $offer->qty_available) * ($cpc->cpc / 100))) - (($offer->cashback * $redeem_count) + (($cpc->cpc / 100) * ($offer->cashback * $redeem_count)));
        $this->cashupdate($offer->user_id, $user->cash + $amount);
        $points = $this->get_points('delete_offer');
        if ($offer->qty_available == $redeem_count) {
            $points1 = 0;
        } else {
            $remaining_percentage = 100 - ($redeem_count / $offer->qty_available) * 100;
            $activity_points = round($points->activity_points * ($remaining_percentage / 100));
            $points1 = 0 - $activity_points;
        }
        $this->pointsforactivities(array($points->activity_name, $offer->info), $id, $points->id, $points1, $users = array('id_customer' => 0, 'id_merchant' => $offer->user_id), 2);
        //$this->pointsforactivities(array($points->activity_name . " :" . $offer->cashback . "Off" . $offer->info), $id, $points->id, $points1, $users = array('id_customer' => 0, 'id_merchant' => $offer->user_id), 2);
        $data['info']['response'] = TRUE;
        $data['info']['message'] = 'Offer deleted Successfully';
        $data['info']['balance'] = $this->check_user(array('id' => $id), 'cash');
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function addreview($id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        if (!empty($_POST['review_reply'])) {
            $this->common_model->initialise('offerreviews');
            $where = array('id' => $id);
            $this->common_model->array = array('review_reply' => $_POST['review_reply']);
            if ($this->common_model->update($where) == 0) {
                $this->common_model->initialise('offerreviews as  OFR');
                $this->common_model->join_tables = array('offers as OF', "merchant as ME");
                $this->common_model->join_on = array("OF.id = OFR.id_offer", "OF.user_id = ME.user_id");
                $where = array('OFR.id' => $id);
                $merchant_id = $data['info']['offer_details'] = $this->common_model->get_record_single($where, '*,ME.user_id as id_merchant');
                $data['info']['merchant_id'] = $merchant_id->id_merchant;
                $data['info']['customer_id'] = $merchant_id->id_customer;
                $this->send_push($merchant_id->id_customer, 'Recived review', array('review_id' => $id));
            }
        } else {
            $data['error'] = "Insufficient Data";
        }
        $output = $this->api_model->json($data);
        $this->log($merchant_id->id_merchant, array($merchant_id->id_merchant, 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function r_reply($id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        if (!empty($_POST['message'])) {
            $data['info']['id'] = $this->review_messg($id, $_POST['message'], 4);
            $data['info']['message'] = 'Successfully added';
        } else {
            $data['error'] = 'Insufficient Data';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function get_reviews($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $where = array('F.user_id' => $id ,'RM.user_type' => 5);
        $reviews_list = $this->reviewinfo($where, null);
        if (!empty($reviews_list)) {
            $data['info'] = $reviews_list;
            $data['response'] = TRUE;
        } else {
            $data['response'] = FALSE;
            $data['info']['message'] = 'No reviews found';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    //review report
    public function reviewreport($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }//$customer_id is nothing but user_id
        $data = array();
        $this->common_model->initialise('offerreviews');
        $this->common_model->status = '2';
        $user_update = $this->common_model->set_status("id = '" . $id . "'");
        if ($user_update == 0) {
            $data['response'] = FALSE;
            $data['error'] = $data['message'] = 'Please try again';
        } else {
            $data['response'] = TRUE;
            $data['info'] = $data['message'] = 'Review reported Successfully';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    /*
     * Offers end
     */

    // customer details
    //Followers List
    public function followlist($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $get_follow_details = $this->common_model->storeprocedure("FollowerList({$id})");
        if (!empty($get_follow_details)) {
            $data['info']['follow_list'] = $get_follow_details;
        } else {
            $data['error'] = "You have no followers to display";
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    //Follower Detail
    public function followerdetails($id, $merchant_id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('users');
        $where['id'] = $where_c['user_id'] = $id;
        $user_details = $this->common_model->get_record_single($where, 'firstname,lastname,email');

        $this->common_model->initialise('merchant');
        $merchant_details = $this->common_model->get_record_single(array('user_id'=>$merchant_id), '*');

        if (!empty($user_details)) {
            $customer = (array) $this->common_model->storeprocedure("CustomerDetails({$id})");
            $data['info']['user_customer'] = (array) $customer[0];
        } else {
            $data['error'] = "Check the user id";
        }
        $this->common_model->initialise('followers as FO');
        $this->common_model->join_tables = "merchant as ME";
        $this->common_model->join_on = "ME.user_id = FO.id_user";
        $whe = array("FO.id_follower" => $id, "FO.id_user <>" => $merchant_id);
        $select = array("ME.*");
        $customer_followed_merchants = $this->common_model->get_records(0, $select, $whe);
        if (!empty($customer_followed_merchants)) {
            $data['info']['customer_followed_merchants'] = $customer_followed_merchants;
        } else {
            $data['info']['customer_followed_merchants']['error'] = "No Followed Merchants";
        }

        $this->common_model->initialise('customersavedoffers as CS');
        $this->common_model->join_tables = array("offers as OF", "merchant as ME");
        $this->common_model->join_on = array("CS.id_offer = OF.id","ME.user_id = OF.user_id");
        $whe = array("CS.id_customer" => $id, "OF.status" => 1);
        $select = array("DATE_FORMAT(CS.datecreated,'%e') as day,DATE_FORMAT(CS.datecreated,'%b %y') as month,OF.cashback,OF.info, OF.id as offer_id, OF.user_id as merchant_id, ME.display_name, ME.business_name");
        $active_offer_details = $this->common_model->get_records(0, $select, $whe);
        if (!empty($active_offer_details)) {
            $data['info']['customersaved_list'] = $active_offer_details;
        } else {
            $data['info']['customersaved_list']['error'] = "there is no active offers";
        }
        $this->common_model->initialise('offerredeemd as RD');
        $this->common_model->join_tables = array("offers as OF", "merchant as ME");
        $this->common_model->join_on = array("RD.id_offer = OF.id","ME.user_id = OF.user_id");
        //echo $merchant_details->followers_management; exit;
        if($merchant_details->followers_management == 2){
            $whee = array("RD.id_customer" => $id);
        }else{
            $whee = array("RD.id_customer" => $id,'OF.user_id'=>$merchant_id);

        }

        $selecte = array("DATE_FORMAT(RD.datecreated,'%e') as day,DATE_FORMAT(RD.datecreated,'%b %y') as month,OF.cashback,OF.info, OF.id as offer_id, RD.datecreated as redeem_date,OF.user_id as merchant_id, ME.display_name, ME.business_name");
        $redeemed_offer_details = $this->common_model->get_records(0, $selecte, $whee);
        if (!empty($redeemed_offer_details)) {
            $data['info']['redeemed_offers_list'] = $redeemed_offer_details;
        } else {
            $data['info']['redeemed_offers_list']['error'] = "there is no Redeemed offers";
        }
        //friends count
        $this->common_model->initialise('friends');
        $where = "status = 1 AND (from_user_id = '" . $id . "' OR to_user_id = '" . $id . "')";
        $row = $this->common_model->get_record_single($where, array('count(*) as count'));
        $data['info']['user_customer']['friends_count'] = $row->count;
        //get most redeemed
        $this->common_model->initialise('offerredeemd');
        $select = array('id_merchant', 'count(*) as count');
        $res = $this->common_model->get_records(1, $select, array('id_customer' => $id), 'count', 'asc', 'id_merchant');
        $this->common_model->initialise('merchant');
        if (!empty($res)) {
            $res = $this->common_model->get_record_single(array('user_id' => $res[0]->id_merchant), array('business_name', 'location'));
            $data['info']['user_customer']['most_redeemed'] = $res->business_name . ', ' . $res->location;
        } else {
            $data['info']['user_customer']['most_redeemed'] = 'NA';
        }
        //customer status
        $this->common_model->initialise('points_status');
        $status = $this->common_model->get_records('1', 'name', $where = array('points <= ' => $customer[0]->points), $col = 'points', $order = 'desc');
        $data['info']['user_customer']['user_status'] = 'New';
        if (!empty($status)) {
            $data['info']['user_customer']['user_status'] = $status[0]->name;
        }
        $output = $this->api_model->json($data);
        $this->log($merchant_id, array($merchant_id, 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function follwersofferdetails($id, $offid) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $where['id'] = $where_c['user_id'] = $id;
        $user_details = $this->check_user($where, 'firstname,lastname,email');
        if (!empty($user_details)) {
            $data['info']['user_customer'] = $this->common_model->storeprocedure("CustomerDetails({$id})");
        } else {
            $data['error'] = "Check the user id";
        }
        $this->common_model->initialise('offers as OF');
        $this->common_model->join_tables = "merchant as ME";
        $this->common_model->join_on = "ME.user_id = OF.user_id";
        $where = array('OF.id' => $offid);
        $merchant_id = $this->common_model->get_record_single($where, '*, ME.user_id as merchant_id, OF.id as offer_id');
        $data['info']['offer_details'] = (array) $merchant_id;
        $data['info']['offer_details']['reddemed_count'] = $count_offer = $this->reedemed_count($id);
        $this->common_model->initialise('offerredeemd');
        $where = array('id_offer' => $offid);
        $customer_offer_count = $this->common_model->get_record_single($where, 'count(id_customer) as count');
        $data['info']['offer_details']['customer_redemed_count'] = $customer_offer_count->count;
        if ($count_offer < $merchant_id->qty_available && $customer_offer_count->count < $merchant_id->qty_perperson) {
            $data['info']['offer_status'] = "Avaible";
        } else {
            $data['info']['offer_status'] = "Not Avaible";
        }
        $this->common_model->initialise('customersavedoffers');
        $offer_saved_count = $this->common_model->get_record_single("id_offer = $offid", "count(id_customer) as count");
        $data['info']['offer_saved_count'] = $offer_saved_count->count;
        $output = $this->api_model->json($data);
        $this->log($merchant_id->merchant_id, array($merchant_id->merchant_id, 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function resendoffer($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $this->common_model->initialise('offers');
        $offer_details = $this->common_model->get_record_single(array('id' => $id), "*");
        if ($this->send_push($offer_details->user_id, 'Resend Offer', $custom = array('offer_id' => $id))) {
            $data['info']['message'] = "Sent Successfully";
        } else {
            $data['error'] = "Try again later";
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function emailblast($id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $this->common_model->initialise('blast');
        $this->common_model->array = array('user_id' => $id, 'message' => $_POST['message'], 'amount' => $_POST['amount']);
        $last_id = $this->common_model->insert_entry();
        if (is_numeric($last_id)) {
            $user_details = $this->check_user(array('id' => $id), 'cash');
            $this->cashupdate($id, $user_details->cash - $_POST['amount']);
            $data['info']['message'] = "Recorded will be sent";
        } else {
            $data['error'] = "Try again";
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

}

?>