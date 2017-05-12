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
class APICUSTOMER extends My_Controller {

    //put your code here
    public $login_error = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }

    public function view($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('users');
        $where['id'] = $where_c['user_id'] = $id;
        $user_details = $this->common_model->get_record_single($where, 'firstname,lastname,email');
        //print_r($where['id']); exit;
        if (!empty($user_details)) {
            $customer = $data['info']['user_customer'] = $this->common_model->storeprocedure("CustomerDetails({$id})");
            $this->common_model->initialise('points_status');
            $status = $this->common_model->get_records('1', 'name', $where = array('points <=' => $customer[0]->points), $col = 'points', $order = 'desc');
            $data['info']['user_status'] = 'New';
            if (!empty($status)) {
                $data['info']['user_status'] = $status[0]->name;
            }
            $this->common_model->initialise('friends');
            $friends = $this->common_model->get_record_single("(from_user_id = $id OR to_user_id = $id) AND to_user_id <> 0", 'count(id) as count');
            $data['info']['friends_count'] = $friends->count;
            $data['info']['graph_values'] = $this->common_model->storeprocedure("CustomerCashback({$id})");
        } else {
            $data['error'] = "Check the user id";
        }
        $output = $this->api_model->json($data);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function edit() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data_array['updated_on'] = $data_carray['datemodified'] = date("Y-m-d H:i:s");
        $this->common_model->initialise('users');
        $required_feilds = array('firstname', 'lastname', 'displayname', 'email', 'address', 'phone');
        if (!empty($_POST)) {
            foreach ($required_feilds as $key => $value) {
                if (empty($_POST[$value])) {//echo "hi";exit;
                    $data['error'][$value] = "$value should not be empty";
                } elseif ($value == 'address' || $value == 'displayname' || $value == 'phone') {
                    $data_carray[$value] = urldecode($_POST[$value]);
                } elseif ($value == 'firstname' || $value == 'lastname') {
                    ($this->alph_check($_POST[$value]) === false ) ? $data['error'][$value] = "please enter alphabets only for $value" : ($value == 'displayname') ? $data_carray[$value] = ucfirst(urldecode($_POST[$value])) : $data_array[$value] = ucfirst(urldecode($_POST[$value]));
                } elseif ($value == 'email') {
                    if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST['email'])) {
                        $data['error'][$value] = "Please enter valid Email Address";
                    } else {
                        $data_array[$value] = urldecode($_POST[$value]);
                    }
                } else {
                    $data_carray[$value] = urldecode($_POST[$value]);
                }
            }//foreach

            if (empty($data['error'])) {
                $this->common_model->initialise('users');
                $this->common_model->array = $this->trim_addslashes($data_array);
                $user_update = $this->common_model->update("id = '" . $_POST['user_id'] . "'");
                $this->common_model->initialise('customer');
                $this->common_model->array = $this->trim_addslashes($data_carray);
                $customer_update = $this->common_model->update("user_id = '" . $_POST['user_id'] . "'");
                if ($user_update == FALSE && $customer_update == FALSE) {
                    $data['info'] = "Updated Sucessfully";
                } else {
                    $data['error'] = "Please check the given Details";
                }
            } else {
                $data['error'] = "Insufficient data";
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
                        $this->common_model->initialise('customer');
                        $this->common_model->array = array($key => basename($_FILES[$key]["name"]));
                        $where = array('user_id' => $_POST['user_id']);
                        if (!$this->common_model->update($where)) {
                            $data['info'] = array('message' => 'Action completed successfully');
                        }
                    } else {
                        $data['error'] = 'Problem with Upload';
                    }
                }
            }
        }
        $output = $this->api_model->json($data);
        $this->log($_POST['user_id'], array($_POST['user_id'], 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    /*
     * Customer Functinality end
     */
    /*
     * Offers functionality
     */

    public function redeem() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        if (!empty($_POST) && !empty($_POST['offer_id']) && !empty($_POST['password']) && !empty($_POST['user_id'])) {
            $merchant_id = $this->offerdetails(array('OF.id' => $_POST['offer_id']), '*, ME.passcode as password_me');
            $this->common_model->initialise('offerredeemd');
            $where = array('id_offer' => $_POST['offer_id']);
            $count_offer = $this->common_model->get_record_single($where, 'count(id_offer) as count');
            $where['id_customer'] = $_POST['user_id'];
            $customer_offer_count = $this->common_model->get_record_single($where, 'count(id_offer) as count');
            if (!empty($merchant_id) && $count_offer->count < $merchant_id->qty_available && $customer_offer_count->count < $merchant_id->qty_perperson && $_POST['password'] == $merchant_id->password_me) {
                $data['info']['message'] = 'SUC';
            } else {
                $data['error'] = 'Data provided doesnt match';
                if ($count_offer->count >= $merchant_id->qty_available) {
                    $data['error'] = 'Sorry offer limit already exceeded';
                } elseif ($_POST['password'] != $merchant_id->password_me) {
                    $data['error'] = 'Wrong password';
                } elseif ($customer_offer_count >= $merchant_id->qty_perperson) {
                    $data['error'] = 'Sorry you have already used the Offer';
                }
            }
        } else {
            $data['error'] = "Insufficient data";
        }
        $output = $this->api_model->json($data);
        $this->log($merchant_id->user_id, array($merchant_id->user_id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function redeemedoffers($id, $sort_by = 0) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        if ($sort_by == 1) {
            $data['info'] = $merchant_id = $this->common_model->storeprocedure("CustomerRedemeedOffersE({$id})");
        } else {
            $data['info'] = $merchant_id = $this->common_model->storeprocedure("CustomerRedemeedOffersN({$id})");
        }
        if (empty($merchant_id)) {
            $data['error'] = "No redeemed offers";
        }
        $output = $this->api_model->json($data);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function offer($id, $uid) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $select_q = ['*','REPLACE(ME.business_name,"\\\","") as business_name','REPLACE(ME.display_name,"\\\","") as display_name','ME.user_id as merchant_id', 'OF.id as offer_id'];
        //$ss = '*, REPLACE(ME.business_name,"\\"","") as business_name, REPLACE(ME.display_name," \\ ","") as display_name, ME.user_id as merchant_id, OF.id as offer_id';
        $merchant_id = $this->offerdetails(array('OF.id' => $id),$select_q);
        $data['info']['offer_details'] = (array) $merchant_id;
        $data['info']['offer_details']['reddemed_count'] = $count_offer = $this->reedemed_count($id);
        $this->common_model->initialise('offerredeemd');
        $where = array('id_offer' => $id, 'id_customer' => $uid);
        $customer_offer_count = $this->common_model->get_record_single($where, 'count(id_customer) as count');
        $data['info']['offer_details']['customer_redemed_count'] = $customer_offer_count->count;
        $data['info']['offer_status'] = 0;
        if ($count_offer < $merchant_id->qty_available && $customer_offer_count->count < $merchant_id->qty_perperson) {
            $data['info']['offer_status'] = 1;
        }
        $this->common_model->initialise('followers');
        $follower = $this->common_model->get_record_single(array('id_follower' => $uid, 'id_user' => $merchant_id->merchant_id), 'status');
        if (!empty($follower)) {
            $data['info']['follow_status'] = 1;
        } else {
            $data['info']['follow_status'] = 0;
        }
        $this->common_model->initialise('customersavedoffers');
        $saved = $this->common_model->get_record_single(array('id_customer' => $uid, 'id_offer' => $id), 'status');
        if (!empty($saved)) {
            $data['info']['savedoffer_status'] = 1;
        } else {
            $data['info']['savedoffer_status'] = 0;
        }
        $output = $this->api_model->json($data);
        $this->log($merchant_id->user_id, array($merchant_id->user_id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function offersnew() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $where = "(OF.expirydate >= CURRENT_TIMESTAMP OR OF.expirydate = '0000-00-00 00:00:00') AND OF.status = 1";
        //$where = null;
        $p_records = $_POST;
        if (!empty($p_records['offer_value'])) {
            if (!empty($where)) {
                $where .= ' AND ';
            }
            $where .= "OF.cashback <= {$p_records['offer_value']}";
        }
        if (!empty($p_records['category'])) {
            if (!empty($where)) {
                $where .= ' AND ';
            }
            $cate = json_decode($p_records['category']);
            if (count($cate) == 1) {
                $where .= 'OF.category_type like ' . "'%{$cate[0]}%'";
            } else {
                $where .= '( ';
                foreach ($cate as $key => $value) {
                    if (count($cate) > $key + 1) {
                        $where .= 'OF.category_type like ' . "'%{$cate[$key]}%' OR ";
                    } else {
                        $where .= 'OF.category_type like ' . "'%{$cate[$key]}%'";
                    }
                }
                $where .= ' )';
            }
        }
        $select = array(
            "`ME`.`user_id` as merchant_id, `ME`.`business_name`, `ME`.`display_name`, `ME`.`phone`, `ME`.`category`, `ME`.`address`, `ME`.`lat`, `ME`.`lng`, `ME`.`facebook_page_name`, `ME`.`facebook_page_id`,OF.id as offer_id, OF.*,if((SELECT COUNT(id_offer) FROM tbl_offerredeemd where id_offer = OF.id GROUP BY OF.id) is null, 0, (SELECT COUNT(id_offer) FROM tbl_offerredeemd where id_offer = OF.id GROUP BY OF.id)) as reedem_count,
         ( 3959 * acos( cos( radians({$p_records['lat']}) ) * cos( radians( ME.lat ) ) * cos( radians( ME.lng ) - radians({$p_records['lng']}) ) + sin( radians({$p_records['lat']}) ) * sin( radians( ME.lat ) ) ) ) AS dista", "if(OF.expirydate IN ('0000-00-00 00:00:00'), 'Never', OF.expirydate) as expirydate"
        );
        $this->common_model->initialise('offers as OF');
        $this->common_model->join_tables = "merchant as ME";
        $this->common_model->join_on = "OF.user_id = ME.user_id";
        $data['info'] = $result = $this->common_model->get_records(100, $select, $where, 'OF.datecreated', 'desc', 'ME.user_id', "dista < {$p_records['radius']}");
        if (empty($result)) {
            $data['error'] = 'No Results';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function addreview($id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $merchant_id = $this->offerdetails(array('OF.id' => $id), 'OF.name, OF.info, OF.expirydate,OF.terms, OF.qty_perperson,OF.qty_available,OF.cashback, ME.user_id, ME.passcode as password_me, OF.user_id as merchant_id, ME.business_name, ME.display_name');
        if (!empty($_POST) && !empty($_POST['user_id']) && isset($_POST['publish_type']) && (!empty($_POST['rating']) || !empty($_POST['review']))) {
            $this->common_model->initialise('offerredeemd');
            if ($_POST['publish_type'] == 1) {
                $cashback = $merchant_id->cashback;
            } else {
                $cashback = $merchant_id->cashback / 2;
            }
            $this->common_model->array = array('id_offer' => $id, 'id_customer' => $_POST['user_id'], 'id_merchant' => $merchant_id->user_id, 'amount' => $cashback);
            $last_id = $this->common_model->insert_entry();
            if (is_numeric($last_id)) {
                $user = $this->check_user(array('id' => $_POST['user_id']));
                $this->cashupdate($_POST['user_id'], $user->cash + $cashback);
                $points = $this->get_points($this->router->fetch_method());
                $data['info']['reedemed_id'] = $last_id;
                $data['info']['customer_id'] = $_POST['user_id'];
                $data['info']['merchant_id'] = $merchant_id->user_id;
                $customer_details = $this->check_user($where = array('id' => $_POST['user_id']));
                $this->pointsforactivities(array("Redemeed Offer : $" . number_format($cashback, 2) . " " . $merchant_id->display_name, "Redeemed by {$customer_details->firstname} {$customer_details->lastname}"), $id, 9, $points->activity_points, $users = array('id_customer' => $_POST['user_id'], 'id_merchant' => $merchant_id->user_id));
                $data['info']['message'] = "Successfully redeemed offer";
            } else {
                $data['error'] = 'data error';
            }
            $this->common_model->initialise('offerreviews');
            $this->common_model->array = array('id_offer' => $id, 'id_customer' => $_POST['user_id'], 'rating' => $_POST['rating']);
            $last_id = $data['info']['reviews_id'] = $this->common_model->insert_entry();
            if (is_numeric($last_id)) {
                $this->common_model->initialise('review_messages');
                $this->common_model->array = array('review_id' => $last_id, 'user_type' => 5, 'message' => $_POST['review'], 'review_type' => 1);
                $this->common_model->insert_entry();
                $data['info']['offer_details'] = (array) $merchant_id;
                $data['info']['offer_details']['reddemed_count'] = $count_offer = $this->reedemed_count($id);
                $points = $this->get_points($this->router->fetch_method());
                $data['info']['merchant_id'] = $merchant_id->user_id;
                $data['info']['customer_id'] = $_POST['user_id'];
                $this->pointsforactivities(array("$points->activity_name: $ " . number_format($merchant_id->cashback, 2) . " off {$merchant_id->business_name}", $_POST['review']), $last_id, $points->id, $points->activity_points, $users = array('id_customer' => $_POST['user_id'], 'id_merchant' => $merchant_id->user_id));
                $this->send_push($merchant_id->user_id, 'Received review', array('review_id' => $last_id));
            }
            $data['info']['real_cashback'] = $cashback;
        } else {
            $data['error'] = "Insufficient Data";
        }
        $output = $this->api_model->json($data);
        $this->log($merchant_id->user_id, array($merchant_id->user_id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function r_reply($id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        if (!empty($_POST['message'])) {
            $data['info']['id'] = $this->review_messg($id, $_POST['message'], 5);
            $data['info']['message'] = 'Successfully added';
        } else {
            $data['error'] = 'Insufficient Data';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function reviewslist($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $where = array('R.id_customer' => $id, 'R.status <>' => 2);
        //$where = array('R.id_customer' => $id, 'R.status <>' => 2,'RM.user_type' => 4);
        $reviews_list = $this->reviewinfo($where, null);
        if (!empty($reviews_list)) {
            $data['info']['reviews'] = $reviews_list;
            $data['response'] = TRUE;
        } else {
            $data['error'] = "No reviews found.";
            $data['response'] = FALSE;
        }
        $output = $this->api_model->json($data, true);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:s:i'), $output));
        echo $output;
    }

    public function savedoffers($id, $sort_by = 0) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        if ($sort_by == 1) {
            $data['info'] = $merchant_id = $this->common_model->storeprocedure("CustomerSavedOffersE({$id})");
        } else {
            $data['info'] = $merchant_id = $this->common_model->storeprocedure("CustomerSavedOffersN({$id})");
        }
        if (empty($merchant_id)) {
            $data['error'] = "There are no saved offers to display.";
        }
        $output = $this->api_model->json($data);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function saveoffer($ofid, $id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('offers');
        $whe = array('id' => $ofid);
        $getmerchant_id = $this->common_model->get_record_single($whe, 'user_id');
        $getmerchant_id = (array) $getmerchant_id;
        $this->common_model->initialise('customersavedoffers');
        $whee = array('id_offer' => $ofid, 'id_merchant' => $getmerchant_id['user_id'], 'id_customer' => $id);
        $check = $this->common_model->get_record_single($whee, 'count(*) as num, status');
        if ($check->num == 0) {
            $this->common_model->array = array('id_offer' => $ofid, 'id_merchant' => $getmerchant_id['user_id'], 'id_customer' => $id, 'status' => 1);
            $insert = $this->common_model->insert_entry();
            if ($insert) {
                $data['info'] = "Offer saved Sucessfully";
            }
        } else {
            if ($check->status == 0) {
                $this->common_model->array = array('status' => 1);
                $this->common_model->update($whee);
                $data['info'] = "Offer saved Sucessfully";
            } else {
                $data['error'] = "Already saved, try redeem";
            }
        }
        $output = $this->api_model->json($data, true);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function sendoffertofriend($id, $offer_id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise("friends");
        $frind_ids = $this->common_model->get_records(0, 'to_user_id', "from_user_id = $id");
        if (!empty($frind_ids)) {
            foreach ($frind_ids as $key => $value) {
                $this->common_model->initialise('sendoffers');
                $this->common_model->array = array('offer_id' => $offer_id, 'id_from' => $id, 'id_to' => $value->to_user_id, 'status' => 1);
                $data['info']['sent'] = $this->common_model->insert_entry();
            } if (!empty($data['info']['sent'])) {
                $offer_detail = $this->offerdetails("OF.id = $offer_id", "OF.info,OF.cashback,ME.business_name");
                $points = $this->get_points($this->router->fetch_method());
                $this->pointsforactivities(array("$points->activity_name: {$offer_detail->info}, {$offer_detail->cashback} of {$offer_detail->business_name}"), $offer_id, $points->id, $points->activity_points, $users = array('id_customer' => $id, 'id_merchant' => 0));
                $data['info'] = "Offer Send to Icheck Friends Sucessfully";
            } else {
                $data['error'] = "there are no friends for u";
            }
        }
        $output = $this->api_model->json($data, true);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function deletesavedoffer($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('customersavedoffers');
        $check = $this->common_model->get_record_single("id = $id and status = 1", 'count(*) as num');
        if ($check->num > 0) {
            $this->common_model->array = array('status' => 0);
            $delete = $this->common_model->update("id = $id");
            if ($delete == false) {
                $data['info'] = "Saved Offer Deleted sucessfully ";
            }
        } else {
            $data['error'] = "There is no offer saved";
        }
        $output = $this->api_model->json($data, true);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d
H:i:s'), $output));
        echo $output;
    }

    public function dod() {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['info'] = $this->offerdetails('(OF.expirydate >= CURDATE() OR OF.expirydate = "0000-00-00 00:00:00") AND OF.status = 1', 'ME.user_id as merchant_id,ME.display_name,ME.business_name,ME.address,ME.location,OF.cashback,OF.info, OF.qty_available,OF.id as offer_id, MAX(OF.cashback), ME.display_name');
        if (empty($data['info'])) {
            $data['error'] = "No DOD";
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    /*
     * Offers functinality fiished
     */
    /*
     * Merchant functionality start
     */

    public function followus($id, $user_id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('followers');
        $whee = array('id_user' => $id, 'id_follower' => $user_id);
        $check = $this->common_model->get_record_single($whee, 'count(*) as num');
        if ($check->num == 0) {

            $this->common_model->array = array('id_user' => $id, 'id_follower' => $user_id, 'status' => 1);
            $insert = $this->common_model->insert_entry();
            if (!empty($insert)) {
                $this->common_model->initialise('merchant');
                $wh = array("user_id" => $id);
                $get_merchant = $data['info']['merchant_details'] = $this->common_model->get_record_single($wh, 'business_name,address');
                $points = $this->get_points($this->router->fetch_method());
                $customer = $this->check_user($where = array('id' => $user_id));
                $this->pointsforactivities(array("$points->activity_name", "{$customer->firstname}  {$customer->lastname}"), $user_id, $points->id, $points->activity_points, $users = array('id_customer' => $user_id, 'id_merchant' => $id));
                $data['info']['message'] = "Follow Request Sent to Merchant Sucessfully";
            }
        } else {
            $data['error'] = "You already following the Merchant";
        }
        $output = $this->api_model->json($data, true);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function get_business($lat, $long, $radius) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $result = (array) $this->common_model->storeprocedure("Business({$lat}, {$long}, {$radius})");
        if ($result) {
            $data['info'] = $result;
            $this->common_model->initialise('business as B');
            $this->common_model->join_tables = "invitebusiness as IB";
            $this->common_model->join_on = "B.id = IB.business_id";
            $where = 0;
            $data['invited_count'] = $result = count($this->common_model->get_records(100, "( 3959 * acos( cos( radians($lat) ) * cos( radians( B.lat ) ) * cos( radians( B.lng ) - radians($long) ) + sin( radians($lat) ) * sin( radians( B.lat ) ) ) ) AS dista", $where, 'dista', $order = 'asc', 'B.id', "dista < $radius"));
        } else {
            $data['error'] = 'No Merchants found';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function get_all_business($lat, $long, $radius) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $result = (array) $this->common_model->storeprocedure("CompleteBusiness({$lat}, {$long}, {$radius})");
        if ($result) {
            $data['info']['business_list'] = $result;
            $data['info']['offers_list'] = (array) $this->common_model->storeprocedure("OffersList({$lat}, {$long}, {$radius})");
//            $this->common_model->initialise('business as B');
//            $this->common_model->join_tables = "invitebusiness as IB";
//            $this->common_model->join_on = "B.id = IB.business_id";
//            $where = 0;
//            $data['invited_count'] = $result = count($this->common_model->get_records(100, "( 3959 * acos( cos( radians($lat) ) * cos( radians( B.lat ) ) * cos( radians( B.lng ) - radians($long) ) + sin( radians($lat) ) * sin( radians( B.lat ) ) ) ) AS dista", $where, 'dista', $order = 'asc', 'B.id', "dista < $radius"));
        } else {
            $data['error'] = 'No Merchants found';
        }
	//$data_afterslash = $this->stripslashes_deep($data);
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function search_business() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        if(!empty($_POST) && !empty($_POST['lat']) && !empty($_POST['lng']) && !empty($_POST['radius']) /*&& isset($_POST['search_type'])*/){
            $merchant_column = ['M.address','M.search_column','M.category','M.display_name','M.business_name','OF.cashback','OF.category_type'];
            $business_column = ['B.address','B.search_column','B.category','B.display_name','B.business_name','OF.cashback','OF.category_type'];
            if(!empty($_POST['search_type'])){
                $search_type = $_POST['search_type'];
            }else{
                $search_type = 1/*$_POST['search_type']*/;
            }


            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $radius = $_POST['radius'];
            if(!empty($_POST['category'])){
                if(empty($_POST['search_word'])){
                    $search_type = 2;
                    $result = (array) $this->common_model->storeprocedure("SearchBusiness('{$_POST['category']}','{$merchant_column[$search_type]}','{$business_column[$search_type]}',{$lat},{$lng},{$radius})");
                }else{
                    $search_word = $_POST['search_word'];
                    $result = (array) $this->common_model->storeprocedure("SearchBusinessByCategory('{$search_word}','{$merchant_column[$search_type]}','{$business_column[$search_type]}','{$_POST['category']}',{$lat},{$lng},{$radius})");
                }

            }else{
                $search_word = $_POST['search_word'];
                //echo "SearchBusiness(".'"'.$search_word.'"'.",'{$merchant_column[$search_type]}','{$business_column[$search_type]}',{$lat},{$lng},{$radius})";
                //$search_word = addslashes($search_word);
                 //echo $search_word = mysqli_real_escape_string($search_word); exit;
                //exit;
                //echo $merchant_column[$search_type];
                $params['search_word'] = $search_word;
                $params['merchant_column'] = $merchant_column[$search_type];
                $params['business_column'] = $business_column[$search_type];
                $params['lat'] = $lat;
                $params['lng'] = $lng;
                $params['radius'] = $radius;
                $result = (array) $this->common_model->storeprocedureS("SearchBusiness",$params);
                //print_r($result); exit;
            }

            //$result = (array) $this->common_model->storeprocedure("SearchBusiness('{$search_word}')");
            if (!empty($result)) {
                $data['info']['business_list'] = $result;
                //$data['info']['offers_list'] = (array) $this->common_model->storeprocedure("OffersList({$lat}, {$long}, {$radius})");
//            $this->common_model->initialise('business as B');
//            $this->common_model->join_tables = "invitebusiness as IB";
//            $this->common_model->join_on = "B.id = IB.business_id";
//            $where = 0;
//            $data['invited_count'] = $result = count($this->common_model->get_records(100, "( 3959 * acos( cos( radians($lat) ) * cos( radians( B.lat ) ) * cos( radians( B.lng ) - radians($long) ) + sin( radians($lat) ) * sin( radians( B.lat ) ) ) ) AS dista", $where, 'dista', $order = 'asc', 'B.id', "dista < $radius"));
            } else {
                $data['error'] = 'No Merchants found';
            }
        }else{
            $this->api_model->response('', 406);
        }


        $output = $this->api_model->json($data);
        echo $output;
    }

    public function invite_business($customer_id, $business_id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('users');
        $this->common_model->array = array('login_status' => '2');
        $user_update = $this->common_model->update("id = '" . $customer_id . "'");
        if ($user_update != 0) {
            $data['error'] = $data['message'] = 'Please try again';
        } else {
            if (!empty($business_id)) {
                $user_details = $this->check_user(array('id' => $customer_id));
                $this->common_model->initialise('invitebusiness');
                $this->common_model->array = array('business_id' => $business_id, 'user_id' => $customer_id);
                $ins = $this->common_model->insert_entry();
                $this->common_model->initialise('hashurl');
                $code = hash('sha512', hash('md5', $ins) . hash('md5', date('ymdHis')));
                $this->common_model->array = array('user_id' => $ins, 'hashcode' => $code, 'type' => 4);
                $hashcode = $this->common_model->insert_entry();
                $this->common_model->initialise('business');
                $business_detail = $this->common_model->get_record_single("id = $business_id", "business_name , email");
                $points = $this->get_points($this->router->fetch_method());
                $this->pointsforactivities(array("$points->activity_name: $business_detail->business_name"), $customer_id, $points->id, $points->activity_points, $users = array('id_customer' => $customer_id, 'id_merchant' => 0));
                $data['info'] = 'Business Invited Successfully';
                $this->load->model('communication_model');
                $this->communication_model->merchant_invitation(array('email' => $business_detail->email, 'message' => $code, 'firstname' => $business_detail->business_name, 'customer_name' => $user_details->firstname . ' ' . $user_details->lastname));
            } else {
                $data['info'] = 'Status Changed Successfully';
            }
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function customer_invited_business($customer_id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();

        $this->common_model->initialise('users');
        $this->common_model->array = array('login_status' => '2');
        $user_update = $this->common_model->update("id = '" . $customer_id . "'");
        if ($user_update != 0) {
            $data['error'] = $data['message'] = 'Please try again';
        } else {

            $user_details = $this->check_user(array('id' => $customer_id));
            $this->common_model->initialise('customer_invited_business');
            $this->common_model->array = $_POST;
            $ins = $this->common_model->insert_entry();
            $this->common_model->initialise('hashurl');
            $code = hash('sha512', hash('md5', $ins) . hash('md5', date('ymdHis')));
            $this->common_model->array = array('user_id' => $ins, 'hashcode' => $code, 'type' => 5);
            $hashcode = $this->common_model->insert_entry();
            $data['info'] = 'Business Invited Successfully';
            $this->load->model('communication_model');
            $this->communication_model->merchant_invitation(array('email' => $_POST['email'], 'message' => $code, 'firstname' => $_POST['name'], 'customer_name' => $user_details->firstname . ' ' . $user_details->lastname));

            $data['info'] = 'Status Changed Successfully';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function merchantinfo($id, $merchant_id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('offers');
        $where = "user_id = $merchant_id and (expirydate >= CURDATE() or expirydate = '0000-00-00 00:00:00')";
        $current_offers = (array) $this->common_model->get_records(0, array("DATE_FORMAT(datecreated,'%e') as day,DATE_FORMAT(datecreated,'%b %y') as month, name,info, terms, id as offer_id,expirydate,cashback, datecreated"), $where, 'datecreated', 'desc');
        if (!empty($current_offers)) {
            $data['info']['current_offers'] = $current_offers;
            foreach ($current_offers as $key => $value) {
                $in_array_keys[] = $value->offer_id;
            }
            $in_array_keys = implode(', ', $in_array_keys);
            /*$reviews = $this->reviewinfo("M.user_id = $merchant_id", null);
            if (!empty($reviews)) {
                $data['info']['reviews'] = $reviews;
            } else {
                $data['info']['reviews']['error'] = "There are no reviews for current offers";
            }
            $this->common_model->initialise('offerredeemd as OFR');
            $this->common_model->join_tables = "offers as OF";
            $this->common_model->join_on = "OFR.id_offer = OF.id";
            $wheree = array('OFR.id_customer' => $id, 'OFR.id_merchant' => $merchant_id);
            $redeem_details = $this->common_model->get_records(0, array(" DATE_FORMAT(OF.datecreated,'%e') as day, DATE_FORMAT(OF.datecreated,'%b %y') as month,OF.name,OF.info,OF.cashback,OFR.datecreated, OF.terms, OF.datecreated"), $wheree);
            if (!empty($redeem_details)) {
                $data['info']['trancations'] = $redeem_details;
            } else {
                $data['info']['trancations']['error'] = "There is no transactions for this offer";
            }*/

        } else {
            $data['info']['current_offers']['error'] = "There are no offer's to display";
            $data['info']['reviews']['error'] = "No reviews done yet";
            $data['info']['trancations']['error'] = "No transactions done yet";
        }
        $reviews = $this->reviewinfo("M.user_id = $merchant_id", null);
        if (!empty($reviews)) {
            $data['info']['reviews'] = $reviews;
        } else {
            $data['info']['reviews']['error'] = "There are no reviews for current offers";
        }
        $this->common_model->initialise('offerredeemd as OFR');
        $this->common_model->join_tables = "offers as OF";
        $this->common_model->join_on = "OFR.id_offer = OF.id";
        $wheree = array('OFR.id_customer' => $id, 'OFR.id_merchant' => $merchant_id);
        $redeem_details = $this->common_model->get_records(0, array(" DATE_FORMAT(OF.datecreated,'%e') as day, DATE_FORMAT(OF.datecreated,'%b %y') as month,OF.name,OF.info,OF.cashback,OFR.datecreated, OF.terms, OF.datecreated"), $wheree);
        if (!empty($redeem_details)) {
            $data['info']['trancations'] = $redeem_details;
        } else {
            $data['info']['trancations']['error'] = "There is no transactions for this offer";
        }
        $this->common_model->initialise('followers');
        $follower = $this->common_model->get_record_single(array('id_follower' => $id, 'id_user' => $merchant_id), 'status');
        if (!empty($follower)) {
            $data['info']['follow_status'] = 1;
        } else {
            $data['info']['follow_status'] = 0;
        }
        $output = $this->api_model->json($data, true);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    /*
     * Merchant functionality end
     */
    /*
     * Friend functionality
     */

    public function invitefriend() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('users as U');
        $this->common_model->join_tables = "user_types as UT";
        $this->common_model->join_on = "UT.user_id = U.id";
        if (!empty($_POST['email'])) {
            $where = array("U.email" => $_POST['email']);
            $wh = array("INF.email" => $_POST['email'], 'F.from_user_id' => $_POST['user_id']);
            $active_to = $_POST['email'];
        }
        if (!empty($_POST['facebook_id'])) {
            $where = array("U.facebook_id" => $_POST['facebook_id']);
            $wh = array("INF.facebook_id" => $_POST['facebook_id'], 'F.from_user_id' => $_POST['user_id']);
            $active_to = $_POST['facebook_id'];
        }
        $check = (array) $this->common_model->get_record_single($where, 'U.id,UT.user_type');
        if (count($check) > 0 && $check['user_type'] == '5' && $check['id'] != $_POST['user_id']) {
            $this->common_model->initialise('friends');
            $checkf = (array) $this->common_model->get_record_single("(to_user_id = " . $check['id'] . " AND from_user_id = " . $_POST['user_id'] . ") OR (to_user_id = " . $_POST['user_id'] . " AND from_user_id = " . $check['id'] . ")", '*');
            if (count($checkf) > 0) {
                $data['error'] = "Invitation Already Sent";
            } else {
                $this->common_model->initialise('friends');
                $this->common_model->array = array('to_user_id' => $check['id'], 'from_user_id' => $_POST['user_id']);
                $insert = $this->common_model->insert_entry();
                if ($insert) {
                    $data['info'] = "friend request sent sucessfully";
                } else {
                    $data['error'] = "Please Check the Email Id";
                }
            }
        } else {
            $this->common_model->initialise('invitefriend as INF');
            $this->common_model->join_tables = "friends as F";
            $this->common_model->join_on = "F.id=INF.friend_id";

            $checkinvite = $this->common_model->get_record_single($wh, '*');
            if (count($checkinvite) > 0) {
                $data['error'] = "Invitation already Sent ";
            } else {
                $required_feilds = array('firstname', 'phone', 'email');
                if (!empty($_POST)) {
                    $data_array = $_POST;
//                    foreach ($required_feilds as $key => $value) {
//                        if (empty($_POST[$value])) {
//                            $data['error'][$value] = "$value should not be empty";
//                        } elseif ($value == 'firstname') {
//                            ($this->alph_check($_POST[$value]) === false ) ? $data['error'][$value] = "please enter alphabets only for $value" : $data_array[$value] = ucwords($_POST[$value]);
//                        } elseif ($value == 'email') {
//                            if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST['email'])) {
//                                $data['error'][$value] = "Please enter valid Email Address";
//                            } else {
//                                $data_array['email'] = $_POST['email'];
//                            }
//                        } else if ($value == 'phone') {
////                            if (!preg_match("/^[0-9]+$/", $_POST['phone'])) {
////                                $data['error'][$value] = "Phone Number Contains Numericals Only";
////                            } else {
//                            $data_array['phone'] = $_POST[$value];
////                            }
//                        }
                    //               }
                    if (empty($data['error'])) {
                        $this->common_model->initialise('friends');
                        $this->common_model->array = array('from_user_id' => $_POST['user_id']);
                        $insert = $this->common_model->insert_entry();
                        if ($insert) {
                            $data_array['friend_id'] = $insert;
                            $data_array['location'] = $_POST['location'];
                            unset($data_array['user_id']);
                            $this->common_model->initialise('invitefriend');
                            $this->common_model->array = $this->trim_addslashes($data_array);
                            $data['info']['user_id'] = $this->common_model->insert_entry();
                            if ($data['info']['user_id']) {
                                if (!empty($_POST['email'])) {
                                    $data_iarray = array('firstname' => $_POST['firstname'], 'from' => 'info@icheck.com', 'to' => $_POST['email'], 'friend_id' => $data['info']['user_id'], 'subject' => "Invitation from Icheck App");
                                    //$mail = $this->communication_model->send_invite($data_iarray);
                                    $data['info']['message'] = "Invitaton sent sucess fully";
                                }
                            }
                        } else {
                            $data['error'] = "Please Check the query ";
                        }
                    }
                }
            }
        }
        $userde = $this->check_user(array('id' => $_POST['user_id']));
        if (!empty($insert)) {
            $points = $this->get_points($this->router->fetch_method());
            $this->pointsforactivities(array("$points->activity_name: " . $active_to, "From {$userde->firstname} {$userde->lastname}"), $insert, $points->id, $points->activity_points, $users = array('id_customer' => $_POST['user_id'], 'id_merchant' => 0));
        }
        $output = $this->api_model->json($data, true);
        $this->log($_POST['user_id'], array($_POST['user_id'], 'customer', $this->router->fetch_method(), date('Y-m-d
H:i:s'), $output));
        echo $output;
    }

    public function friendslist($id, $status) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $friends_list = $this->common_model->storeprocedure("FriendsList({$id},{$status})");
        if (!empty($friends_list)) {
            $data['info']['follow_list'] = $friends_list;
        } else {
            $data['error'] = "You have no friends to display";
        }
        $output = $this->api_model->json($data, true);
        $this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    /*
     * Friends functionality end
     */

    public function get_proximal() {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('general');
        $where = array('status' => 1, 'type' => 6);
        $data['info'] = $this->common_model->get_record_single($where, 'general_id, column1 as min_value, column2 as max_value');
        $output = $this->api_model->json($data);
        echo $output;
    }

   
    public function stripslashes_deep($value) {
    	$value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

    		return $value;
	}



}

?>
