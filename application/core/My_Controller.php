<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My_Controller
 *
 * @author kesav
 */
class MY_Controller extends CI_Controller {

    protected $error;
    protected $flag = TRUE;
    private $type_of_users = array('4' => 'merchant', '5' => 'customer');

    public function __construct() {
        parent::__construct();
        $this->emojis['emoji_maps']['html_to_unified'] = array_flip($this->emojis['emoji_maps']['unified_to_html']);
    }

    public function update_by() {
        $data_post = $_POST;
        $data_array = $this->trim_addslashes($data_post);
        $data_array['updated_by'] = $this->session->userdata('admin_user_id');
        $data_array['updated_date'] = date("Y-m-d H:i:s");
        return $data_array;
    }

    public function _is_logged_in() {
        $logged = $this->session->userdata('admin_user_id');
        if (!empty($logged)) {
            return true;
        } else {
            return false;
        }
    }

    public function _is_home_logged_in() {
        $logged = $this->session->userdata('user_id');
        if (!empty($logged)) {
            return true;
        } else {
            return false;
        }
    }

    protected function trim_addslashes($data) {
        foreach ($data as $key => $value) {
            $pattern = "/\d{4}\-\d{2}\-\d{2}/";
            if (!preg_match($pattern, $value, $matches)) {
                if (is_string($value)) {
                    $data[$key] = addslashes(trim($value));
                }
            }
        }
        return $data;
    }

    public function setFlashmessage($type, $message) {
        $this->session->set_flashdata('type', $type);
        $this->session->set_flashdata('msg', $message);
    }

    protected function alph_check($data) {
        if (!preg_match("/^[a-zA-Z ]+$/", $data))
            return false;
        else
            return true;
    }

    protected function change_array($data) {
        foreach ($data as $value) {
            if (is_object($value)) {
                $data_arr[] = $this->object_to_array($value);
            } else {
                $data_arr[] = $value;
            }
        }
        return $data_arr;
    }

    private function object_to_array($data) {
        foreach ($data as $value) {
            if (is_array($value)) {
                $data_array = $this->object_to_array($value);
            } else {
                $data_array = $value;
            }
        }
        return $data_array;
    }

    protected function log($id, $list) {
        $url_to_save = "log/{$id}/" . date('Y') . '/' . date('W');
        if (!is_dir(FCPATH . $url_to_save)) {
            mkdir(FCPATH . $url_to_save, 0777, true);
            chmod(FCPATH . $url_to_save, 0777);
        }
        clearstatcache();
        $fp = fopen(FCPATH . $url_to_save . "/log_file.csv", 'a+');
        //or die('cant open file');
        //chmod(FCPATH . $url_to_save . "/log_file.csv", 0777);
        //foreach ($list as $fields) {
        fputcsv($fp, $list);
        //}
        fclose($fp);
    }

    protected function message_log($id, $data) {
        $url_to_save = "messages_log/{$id}/" . date('Y') . '/' . date('m');
        if (!is_dir(FCPATH . $url_to_save)) {
            mkdir(FCPATH . $url_to_save, 0777, true);
            chmod(FCPATH . $url_to_save, 0777);
        }
        $fp = fopen(FCPATH . $url_to_save . "/log_file.csv", 'a');
        //chmod(FCPATH . $url_to_save . "/log_file.csv", 0777);
        //foreach ($list as $fields) {
        fputcsv($fp, $data);
        //}
        fclose($fp);
    }

    protected function log_login($type) {
        $type;
        $flag = false;
        $url_to_save = "log/";
        if (!is_dir(FCPATH . $url_to_save)) {
            mkdir(FCPATH . $url_to_save, 0777, true);
            chmod(FCPATH . $url_to_save, 0777);
        }
        if (!is_file(FCPATH . $url_to_save . "/log_login.csv")) {
            $fp = fopen(FCPATH . $url_to_save . "/log_login.csv", 'a');
            chmod(FCPATH . $url_to_save . "/log_login.csv", 0777);
            fclose($fp);
        }
        $row = 1;
        $data_array = array();
        if (($handle = fopen(FCPATH . $url_to_save . "/log_login.csv", "r")) !== FALSE && filesize(FCPATH . $url_to_save . "/log_login.csv") != 0) {
//            if (($data = fgetcsv($handle)) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($data[2] == date('Y-m-d') && $data[0] == $type) {
                    $flag = true;
                    $data_array[] = array($data[0], $data[1] + 1, $data[2]);
                } else {
                    if (strtotime($data[2]) > strtotime('-7 day')) {
                        $data_array[] = $data;
                    }
                }
            }
            fclose($handle);
            if (!$flag) {
                $data_array[] = array($type, 1, date('Y-m-d'));
            }
        } else {
            $data_array[] = array($type, 1, date('Y-m-d'));
        }
        $fp = fopen(FCPATH . $url_to_save . "/log_login.csv", 'w');
        foreach ($data_array as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
        //foreach ($list as $fields) {
        //}
    }

    protected function reedemed_count($id) {
        $this->common_model->initialise('offerredeemd');
        $where = array('id_offer' => $id);
        $count = $this->common_model->get_record_single($where, 'COUNT(id_offer)as count');
        return $count->count;
    }

    protected function bussiness_hours($data, $user_id) {
        foreach ($data as $key => $value) {
            $this->common_model->initialise('business_hours');
            $where = array('user_id' => $user_id, 'day' => $value->day);
            $this->common_model->array = (array) $value;
            $count = $this->common_model->get_record_single($where, 'id');
            if (empty($count)) {
                $this->common_model->array['user_id'] = $user_id;
                if (!$this->common_model->insert_entry()) {
                    $this->flag = false;
                }
            } else {
                if (!$this->common_model->update($where)) {
                    $this->flag = false;
                }
            }
        }
        return true;
    }

    protected function ichecksettings($id = null) {
        $this->common_model->initialise('icheksettings');
        $where = array('status' => 1);
        if (!empty($id)) {
            $where = array('icheksetting_id' => $id);
        }
        return $this->common_model->get_record_single($where, '*');
    }

    protected function pointsforactivities($activity_name, $activity_id, $type, $points, $users, $points_type = 1) {
        if (!empty($activity_name[1])) {
            $sub = $activity_name[1];
        } else {
            $sub = null;
        }
        $data = array('activity' => $activity_name[0], 'activity_sub' => $sub, 'activity_id' => $activity_id, 'type' => $type, 'points' => $points, 'id_customer' => $users['id_customer'], 'id_merchant' => $users['id_merchant']);
        if ($points_type == 2) {
            $data['points'] = 0 - $points;
        }
        $this->common_model->initialise('ichekpointsforactivity');
        $this->common_model->array = $data;
        $insert = $this->common_model->insert_entry();
        $customer_types = array(3, 4, 5, 6, 7, 8, 9, 10, 12);
        if (in_array($type, $customer_types)) {
            $total = $this->total_points(array('id_customer' => $users['id_customer']));
        } else {
            if ($type = 11) {
                (!empty($users['id_customer'])) ? $total = $this->total_points(array('id_customer' => $users['id_customer'])) : $total = $this->total_points(array('id_merchant' => $users['id_merchant']));
            } else {
                $total = $this->total_points(array('id_merchant' => $users['id_merchant']));
            }
        }
        $this->common_model->initialise('users');
        $this->common_model->array = array('points' => $total->total);
        $this->common_model->update(array('id' => (!empty($users['id_customer'])) ? $users['id_customer'] : $users['id_merchant']));
        return $insert;
    }

    protected function total_points($where) {
        $this->common_model->initialise('ichekpointsforactivity');
        //$where = array('user_id' => $id);
        $data = $this->common_model->get_record_single($where, 'SUM(points) as total');
        return $data;
    }

    protected function send_push($id, $action, $custom, $parm = null) {

        if ($action == 'Added Offer' || $action == 'Resend Offer' || $action == 'Edited Offer') {
            $this->common_model->initialise('followers');
            $ids = $this->common_model->get_record_single(array('id_user' => $id), 'GROUP_CONCAT(CONCAT(id_follower)) AS ids');
            $where = "userid in ({$ids->ids})";
            if (empty($ids->ids)) {
                $ids = null;
            }
            if($action == 'Edited Offer'){
                $this->common_model->initialise('offers');
                $offer_details = $this->common_model->get_record_single(array('id' => $custom['offer_id']), '*');
                $action = "Offer updated. $offer_details->name";
            }
        } elseif ($action == 'Received review' || $action == 'Reply' || $action == 'Invitation accepted successfully') {
            $ids = $id;

            if ($action == 'Invitation accepted successfully') {
                $action = 'Invitation accepted successfully';
            } else {
                $action = "Review received";
            }

            $where = array('userid' => $id);
        }
        if (!empty($ids)) {
            $this->common_model->initialise('devicelogs');
            $device_tokens = $this->common_model->get_records('0', 'deviceid', $where, $col = 'id', $order = 'desc', array('deviceid'));
            foreach ($device_tokens as $key => $value) {
                $this->send_notifications($value->deviceid, $action, $custom);
            }
            return true;
        }
    }

    protected function send_notifications($device_token, $message, $custom_message = null) {
        $this->load->library('apn');
        //$this->apn->payloadMethod = 'enhance'; // you can turn on this method for debuggin purpose
        $this->apn->connectToPush();
        // adding custom variables to the notification
        if (!empty($custom_message)) {
            $this->apn->setData($custom_message);
        }
        $send_result = $this->apn->sendMessage($device_token, $message, /* badge */ 1, /* sound */ 'default');
        if ($send_result) {
            log_message('debug', 'Sending successful');
        } else {
            $this->apn->error;
            log_message('error', $this->apn->error);
        }
        $this->apn->disconnectPush();
        return;
    }

    protected function cash($type, $user_record, $email = null) {
        $this->common_model->initialise($type);
        $this->common_model->array = array('amount' => $_POST['amount'], 'user_id' => $_POST['user_id']);
        $last_id = $this->common_model->insert_entry();
        $amount = $user_record->cash + $_POST['amount'];
        if ($type == 'cashout') {
            $iset = $this->ichecksettings();
            $deduction = $_POST['amount'] * ($iset->cash_out_fee / 100);
            if ($deduction > 25) {
                $deduction = 25;
            }
            //echo $_POST['amount']-($_POST['amount']*($iset->cash_out_fee / 100)); exit;
            //$amount = round($user_record->cash - ($_POST['amount'] - $deduction));

            $access_token = $this->paypal();
            $amount1 = $_POST['amount'] - $deduction;
            $data_pa = $this->payout($access_token, $amount1, 'omichek-merchant3@gmail.com', $senderid = 'CO' . $user_record->id . '-' . date('YmdHsi'));

            if ($data_pa->batch_header->batch_status == 'SUCCESS' && $data_pa->items[0]->transaction_status == 'SUCCESS') {
                $amount = $user_record->cash - $_POST['amount'];
                $this->common_model->initialise($type);
                $this->common_model->array = array('transation_id' => $data_pa->items[0]->transaction_id, 'payout_batch_id' => $data_pa->items[0]->payout_batch_id, 'payout_item_id' => $data_pa->items[0]->payout_item_id);
                $last_id = $this->common_model->update(array('id' => $last_id));
                $this->cashupdate($_POST['user_id'], $amount);
                return 'Success';
            } else {
                if(!empty($data_pa->items[0]->errors)){

                    return $data_pa->items[0]->errors;
                }else{
                    //print_r((array)$data_pa);
                    $data_pa = (array)$data_pa;
                    return $data_pa['name'] .' '.$data_pa['message'];
                }

            }
        }
        return $this->cashupdate($_POST['user_id'], $amount);
    }

    protected function check_user($where, $select = '*') {
        $this->common_model->initialise('users');
        return $this->common_model->get_record_single($where, $select);
    }

    protected function cashupdate($id, $amount) {
        $this->common_model->initialise('users');
        $this->common_model->array = array('cash' => $amount);
        $where = array('id' => $id);
        return $this->common_model->update($where);
    }

    protected function get_points($function_name) {
        $this->common_model->initialise('ichekpoints');
        $where = array('function_name' => $function_name);
        return $this->common_model->get_record_single($where, 'activity_name, activity_points, id');
    }

    protected function offerdetails($where, $select = '*') {
        $this->common_model->initialise('offers as OF');
        $this->common_model->join_tables = array('merchant' => "merchant as ME", 'user' => 'users as U');
        $this->common_model->join_on = array('merchant' => "ME.user_id = OF.user_id", 'user' => 'ME.user_id = U.id');
        return $this->common_model->get_record_single($where, $select);
    }

    protected function paypal() {
        $postvals = "grant_type=client_credentials";
        $valussss = $this->curl('https://api.sandbox.paypal.com/v1/oauth2/token','POST', $postvals, true);
        //echo $valussss['body']->access_token;
        return $valussss['body']->access_token;
        print_r($valussss); exit;
        $post_valeus = http_build_query(['grant_type'=>'client_credentials']);
        $ch = curl_init();
        //$clientId = "AQ7Gg4iJdNh_upoi0hipIT5aD98XRV1RbmML_sMmWb9XXxhYOYJbuyQFL4ndO79tCe-26wllXROMAqT5";
        //$secret = "EFjFdoYxH4dplCgWo1uN4lsr9Y1x6H9x7bfpsEk3VHv4-aeYICiN13gXQJWa-Ii4SA5azPKx5r-LEvZE";
        $clientId = "AYtKD764o47AAXYdgXdnacYx9o8q_3XVIJ2pLJ4Zbyhj1Kik5jtIgsSXKSfjWiFQeCx9MUh2AZrV1J2V";
        $secret = "ELytwKytMUM6MZHT6KH2FoZ3JR9kSczDsUttBmghbMqJl5pX8ed7_9rzxUnREdteb3iAfffihZwzRzRW";


        $headers = array();

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        $headers = array("Accept: application/json", "Accept-Language: en_US");
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId. ":" .$secret);
        //curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HEADER, true);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_valeus);
        //curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'ecdhe_rsa_aes_128_gcm_sha_256');
        curl_setopt($ch, CURLOPT_USERAGENT,'cURL/PHP');
        //curl_setopt($ch, CURLOPT_VERBOSE);

        //print_r(curl_getinfo($ch));
        $result = curl_exec($ch);
       //print_r(curl_error($ch)); exit;
        curl_getinfo($ch);
        print_r($result); exit;
        if (empty($result)){

            die("Error: No response.");
           // print_r($result); exit;
        }
        else {
            $json = json_decode($result);
            //print_r($json->access_token);
        }
        curl_close($ch);
        return $json->access_token;
    }

    protected function payout($access_token, $amount, $email, $senderid)
    {
        $ch = curl_init();
        $data = '{
"sender_batch_header": {
        "sender_batch_id": "' . $senderid . '",
        "email_subject": "You have a Payout!",
        "recipient_type": "EMAIL"
    },
    "items": [
        {
            "recipient_type": "EMAIL",
            "amount": {
                "value": ' . $amount . ',
                "currency": "AUD"
            },
            "receiver": "' . $email . '",
            "note": "Payment for recent icheck cashout",
            "sender_item_id": "' . $senderid . '"
        }
    ]
}';

        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payouts?sync_mode=true");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer $access_token",
                "Content-length: " . strlen($data))
        );
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result1 = curl_exec($ch);
        //print_r(curl_error($ch)); exit;
        if (empty($result1)){
            $result1 = ['error' => 'No response.'];
        $json = json_decode($result1);
    }else {
            $json = json_decode($result1);
            //print_r($json);
        }
        curl_close($ch);
        return $json;
    }

    protected function key_date_array_f($type) {
        $data_array = array();
        $this->common_model->initialise($type);
        $data = $this->common_model->get_records(0, "date(datecreated) date, SUM(amount) as $type", 'DATE(datecreated) > DATE_SUB(CURDATE(), INTERVAL 7 DAY)', 'datecreated', 'ASC', 'date(datecreated)');
        foreach ($data as $key => $value) {
            $data_array[$value->date] = $value->$type;
        }
        return $data_array;
    }

    protected function insert_user_type($type, $id, $location, $business_id = null, $merchant_details = null) {
        $this->common_model->initialise('user_types');
        $this->common_model->array = array('user_type' => $type, 'user_id' => $id);
        $this->common_model->insert_entry();
        if(!empty($_POST['mobile'])){
            $mobile = $_POST['mobile'];
        }else{
            $mobile ="";
        }
        $data = array('user_id' => $id, 'location' => $location, 'address' => $location,'mobile' => $mobile);

        if (isset($business_id)) {
            // $data['business_id'] = $business_id;
            $data = (array) $merchant_details;
            $data['business_id'] = $business_id;
            $data['user_id'] = $id;
            $data['location'] = $location;
            $data['mobile'] = $mobile;
        }
        $this->insert_user_details($this->type_of_users[$type], $data);
    }

    protected function insert_user_details($type, $data) {
        $this->common_model->initialise($type);
        $this->common_model->array = $data;
        return $this->common_model->insert_entry();
    }

    protected function reviewinfo($where, $num = 1) {
        $this->common_model->initialise('offerreviews as R');
        $this->common_model->join_tables = array('offers' => 'offers as F', 'merchant' => 'merchant as M', 'customer' => 'customer as C', /* 'offerratings' => 'offerratings as OFR', */ 'user1' => 'users as UC', 'user2' => 'users as UC2', 'review_reply' => 'review_messages as RM');
       // $this->common_model->join_on = array('offers' => 'F.id = R.id_offer', 'merchant' => 'M.user_id = F.user_id', 'customer' => 'C.user_id = R.id_customer', /* 'offerratings' => 'C.user_id = OFR.id_customer AND F.id = OFR.id_offer', */ 'user1' => 'R.id_customer = UC.id', 'user2' => 'M.user_id = UC2.id', 'review_reply' => "R.id = RM.review_id AND RM.user_type = 5 AND RM.review_type = 1");
        $this->common_model->join_on = array('offers' => 'F.id = R.id_offer', 'merchant' => 'M.user_id = F.user_id', 'customer' => 'C.user_id = R.id_customer', /* 'offerratings' => 'C.user_id = OFR.id_customer AND F.id = OFR.id_offer', */ 'user1' => 'R.id_customer = UC.id', 'user2' => 'M.user_id = UC2.id', 'review_reply' => "R.id = RM.review_id");
        $this->common_model->left_join = array('review_reply' => 'left');
        $select = array('RM.view_status', 'R.id_offer', 'R.id_customer', 'F.user_id as id_merchant', 'R.id as review_id', "DATE_FORMAT(R.datecreated,'%e') as day",
            "DATE_FORMAT(R.datecreated,'%b %y') as monthyear", 'R.review', 'F.cashback', 'F.name as productname', 'F.terms',
            'M.business_name', 'M.display_name', 'CONCAT(UC.firstname, " ",UCASE(LEFT(UC.lastname , 1))) as customer_name', 'RM.message as review', 'C.customer_img_url1', 'M.business_logo_url', 'UC.facebook_id as customer_facebook_id', 'UC2.facebook_id as merchant_facebook_id', 'R.rating' /* 'OFR.rating' */);
        if (empty($num)) {
            return $this->common_model->get_records(0, $select, $where, 'R.datecreated', 'desc');
        } else {
            return $this->common_model->get_record_single($where, $select);
        }
    }

    protected function checkfriend($email, $user_id, $facebook_id = null) {
        $this->common_model->initialise('invitefriend');
        $id = $this->common_model->get_record_single($where = array('email' => $email), 'GROUP_CONCAT(CONCAT(friend_id)) AS ids');
        if (!empty($id->ids)) {
            $this->common_model->initialise('friends');
            $this->common_model->array = array('to_user_id' => $user_id);
            $this->common_model->update("id in ($id->ids)");
        }
        if (!empty($facebook_id)) {
            $id = $this->common_model->get_record_single($where = array('facebook_id' => $facebook_id), 'GROUP_CONCAT(CONCAT(friend_id)) AS ids');
            if (!empty($id->ids)) {
                $this->common_model->initialise('friends');
                $this->common_model->array = array('to_user_id' => $user_id);
                $this->common_model->update("id in ($id->ids)");
            }
        }

        return;
    }

    protected function review_messg($review_id, $message, $type) {
        $this->common_model->initialise('review_messages');
        $this->common_model->array = array('review_id' => $review_id, 'user_type' => $type, 'message' => $message);
        $this->common_model->insert_entry();
        $this->common_model->initialise('offerreviews');
        $info = $this->common_model->get_record_single($where = array('id' => $review_id), 'id_offer, id_customer as user_id');
        if ($type == 4) {
            $this->common_model->initialise('offers');
            $info = $this->common_model->get_record_single($where = array('id' => $info->id_offer), 'user_id');
        }
        $this->send_push($info->user_id, 'Reply', array('review_id' => $review_id));
        return;
    }

    protected function change_message_view_status($message_link_id,$user_id){
        $this->common_model->initialise('messages');
        $this->common_model->array = array('view_status' => 1);
        $this->common_model->update(array('messagelink_id' => $message_link_id,'user_id <>' => $user_id));
        return true;
    }

    protected function change_review_view_status($review_id,$user_type){
        $this->common_model->initialise('review_messages');
        $this->common_model->array = array('view_status' => 1);
        $this->common_model->update(array('review_id' => $review_id,'user_type <>' => $user_type));
        return true;
    }

    private function curl($url, $method, $postvals = null, $auth = false){
        $clientId = "AYtKD764o47AAXYdgXdnacYx9o8q_3XVIJ2pLJ4Zbyhj1Kik5jtIgsSXKSfjWiFQeCx9MUh2AZrV1J2V";
        $secret = "ELytwKytMUM6MZHT6KH2FoZ3JR9kSczDsUttBmghbMqJl5pX8ed7_9rzxUnREdteb3iAfffihZwzRzRW";
        $ch = curl_init($url);

        //if we are sending request to obtain bearer token
        if ($auth){
            $headers = array("Accept: application/json", "Accept-Language: en_US","Content-Type: application/x-www-form-urlencoded");
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" .$secret);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            //curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'rsa_rc4_128_md5,rsa_aes_128_sha');
            //if we are sending request with the bearer token for protected resources
        } else {
            $headers = array("Content-Type:application/json", "Authorization:{$this->token_type} {$this->access_token}");
        }

        $options = array(
            CURLOPT_HEADER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => true,
            CURLOPT_TIMEOUT => 10
        );


        if ($method == 'POST'){
            $options[CURLOPT_POSTFIELDS] = $postvals;
            $options[CURLOPT_CUSTOMREQUEST] = $method;
        }

        curl_setopt_array($ch, $options);
       // print_r(curl_getinfo($ch));
        $response = curl_exec($ch);
        //print_r(curl_error($ch));
        //print_r(curl_getinfo($ch));
        $header = substr($response, 0, curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        $body = json_decode(substr($response, curl_getinfo($ch,CURLINFO_HEADER_SIZE)));
        curl_close($ch);

        return array('header' => $header, 'body' => $body);
    }

}
