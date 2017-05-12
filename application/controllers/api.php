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
class API extends My_Controller {

//put your code here
    public $login_error = array();
    private $type_of_users = array('4' => 'merchant', '5' => 'customer');

    public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }

    //Login Method
    public function signup() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $required_feilds = array('firstname', 'lastname', 'location', 'email', 'password');
        $this->common_model->initialise('users');
        $user_record = $this->common_model->get_record_single(array('email' => $_POST['email']), '*');
        $data['response'] = False;
        if (!empty($_POST) & empty($user_record)) {
            $da_ar = $_POST;
            foreach ($required_feilds as $key => $value) {
                if (empty($da_ar[$value])) {
                    $data['error'][$value] = "$value should not be empty";
                } elseif ($value == 'password' || $value == 'location') {
                    if ((strlen($da_ar['password']) < 4)) {
                        $data['error'][$value] = "Password should contain atleast 4 characters";
                    }
                }if ($value == 'firstname' || $value == 'lastname') {
                    ($this->alph_check($da_ar[$value]) === false ) ? $data['error'][$value] = "please enter alphabets only for $value" : $data_array[$value] = ucfirst($da_ar[$value]);
                } elseif ($value = 'email') {
                    $email = $da_ar[$value];
                    if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $da_ar[$value])) {
                        $data['error'][$value] = "Please enter valid Email Address";
                    }
                }
            }//foreach
            if (!empty($data['error'])) {
                $data['message'] = 'Not sufficient data';
            }
            //$data_array['user_type'] = 4;
            if (empty($data['error'])) {
                $location = $da_ar['location'];
                unset($da_ar['location']);
                unset($da_ar['user_type']);
                unset($da_ar['lat']);
                unset($da_ar['lng']);
                //$this->common_model->initialise('merchant');
                $this->common_model->initialise('users');
                $this->common_model->array = $this->trim_addslashes($da_ar);
                $data['info']['user_id'] = $this->common_model->insert_entry();
                $user_array['user_id'] = $data['info']['user_id'];
                if ($_POST['user_type'] == 6) {
                    $this->insert_user_type(4, $data['info']['user_id'], $location, 0, array('lat' => $_POST['lat'], 'lng' => $_POST['lng']));
                    $this->insert_user_type(5, $data['info']['user_id'], $location);
                } else {
                    //print_r( $data['info']['user_id']);
                    if ($_POST['user_type'] == 4) {
                        $this->insert_user_type($_POST['user_type'], $data['info']['user_id'], $location, 0, array('lat' => $_POST['lat'], 'lng' => $_POST['lng']));
                    } else {
                        $this->insert_user_type($_POST['user_type'], $data['info']['user_id'], $location);
                    }
                }
                $this->checkfriend($email, $data['info']['user_id']);
                /* $this->load->library('email');
                  $config['protocol'] = 'sendmail';
                  $config['mailpath'] = '/usr/sbin/sendmail';
                  $config['charset'] = 'iso-8859-1';
                  $config['wordwrap'] = TRUE;
                  $config['mailtype'] = 'html';
                  $this->email->initialize($config);
                  $message = '<html><body>';
                  $message .= '<div>Dear '.$firstname.' '.$lastname.',</div>';
                  $message .= '<div>To activate your Icheck account please click on the following link.</div>';
                  $message .= '<div><a href="http://192.168.0.121/narender/icheck/index.php/api/login/activate">icheck activation link</a></div>';
                  $message .= '</body></html>';
                  $this->email->from('info@icheck.com', 'Icheck');
                  $this->email->to($email);
                  //$this->email->cc('another@another-example.com');
                  //$this->email->bcc('them@their-example.com');
                  $this->email->subject('Icheck:Account activation');
                  $this->email->message($message);
                  $this->email->send();
                  print_r($this->email->print_debugger()); exit; */
                $data['response'] = True;
            }
        } else {
            if (!empty($user_record)) {
                $data['error'] = $data['message'] = 'This email address has already been registered to another account. If you are the account holder, please proceed to login, otherwise please use a new email address.';
            } else {
                $this->api_model->response('', 406);
            }
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function login() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data['response'] = False;
        if (!empty($_POST) && !empty($_POST['email'])) {
            $this->common_model->initialise('users');
            if ($_POST['login_type'] == 1) {
                $id = $this->common_model->get_record_single(array('email' => $_POST['email']), 'id, facebook_id');
                if (!empty($id) && empty($id->facebook_id)) {
                    $where = ['id' => $id->id];
                    $this->common_model->array = $this->trim_addslashes(array('facebook_id' => $_POST['facebook_id']));
                    $this->common_model->update($where);
                }
            } else {
                $id = $this->common_model->get_record_single(array('email' => $_POST['email'], 'password' => $_POST['password']), 'id');
            }
            if (!empty($id)) {
                $data['info'] = (array) $this->common_model->get_record_single(array('id' => $id->id, 'status' => 1), 'id as user_id, email,firstname, lastname, login_status');
                if (!empty($data['info'])) {
                    $this->common_model->initialise('user_types');
                    $da_ar = $this->common_model->get_records(0, 'user_type', array('user_id' => $data['info']['user_id']));
                    $data['info']['user_type'] = $this->change_array($da_ar);
                    //print_r($da_ar[0]->user_type);
                    if ($data['info']['user_type'][0] == 4) {
                        $image = $this->common_model->storeprocedure("MerchantDetails({$data['info']['user_id']})");
                        //print_r($image);
                        $data['info']['image'] = $image[0]->business_logo_url;
                        $data['info']['cash'] = $image[0]->cash;
                        $data['info']['follow_level'] = $image[0]->followers_management;
                        $data['info']['blast_status'] = $image[0]->blast_status;
                        $data['info']['blast_amount'] = $image[0]->blast_amount;
                    } else {
                        $image = $this->common_model->storeprocedure("CustomerDetails({$data['info']['user_id']})");
                        $data['info']['image'] = $image[0]->customer_img_url1;
                        $data['info']['cash'] = $image[0]->cash;
                    }
                    $data['response'] = True;
                    $app_version = 0;
                    if (!empty($_POST['app_version'])) {
                        $app_version = $_POST['app_version'];
                    }

                    $this->log_login_para($data['info']['user_id'], $da_ar[0]->user_type, 1, $app_version);
                } else {
                    $data['error'] = 'Please Contact Administrator' ;
		    $data['message'] = 'Your account has been suspended. Please Contact iChek Administrator.';
                }
            } else {
                if ($_POST['login_type'] == 1) {
                    $data['info'] = $_POST;
                    $data['error'] = $data['message'] = 'Not registered';
                } else {
                    $data['error'] = $data['message'] = 'Invalid user details';
                }
            }
        } else {
            $this->api_model->response('', 204);
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function s_signup() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $required_feilds = array('firstname', 'lastname', 'location', 'email');
        $this->common_model->initialise('users');
        $user_record = $this->common_model->get_record_single(array('email' => $_POST['email']), '*');
        $data_array = $_POST;
        $location = $data_array['location'];
        unset($data_array['location']);
        unset($data_array['user_type']);
        unset($data_array['lat']);
        unset($data_array['lng']);

        if (!empty($_POST) & empty($user_record) & !empty($_POST['user_type'])) {

            $this->common_model->initialise('users');
            $this->common_model->array = $this->trim_addslashes($data_array);
            $data['info']['user_id'] = $this->common_model->insert_entry();
            $user_array['user_id'] = $data['info']['user_id'];
            if ($_POST['user_type'] == 6) {
                $this->insert_user_type(4, $data['info']['user_id'], $location, 0, array('lat' => $_POST['lat'], 'lng' => $_POST['lng']));
                $this->insert_user_type(5, $data['info']['user_id'], $location);
            } else {
                if ($_POST['user_type'] == 4) {
                    $this->insert_user_type($_POST['user_type'], $data['info']['user_id'], $location, 0, array('lat' => $_POST['lat'], 'lng' => $_POST['lng']));
                } else {
                    $this->insert_user_type($_POST['user_type'], $data['info']['user_id'], $location);
                }
            }

            $this->common_model->initialise('users');
            $data['info'] = (array) $this->common_model->get_record_single(array('email' => $_POST['email']), 'id as user_id, email, firstname, lastname, status, login_status');

            $this->common_model->initialise('user_types');
            $da_ar = $this->common_model->get_records(0, 'user_type', array('user_id' => $data['info']['user_id']));
            $data['info']['user_type'] = $this->change_array($da_ar);
            $this->checkfriend($data_array['email'], $data['info']['user_id'], $data_array['facebook_id']);
            $data['response'] = True;
        } else {
            $this->api_model->response(array('error' => 'No content'), 204);
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function forgotpassword() {
        date_default_timezone_set('America/Los_Angeles');
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['response'] = false;
        if (!empty($_POST) && !empty($_POST['email'])) {
            $this->common_model->initialise('users');
            $user_record = $this->common_model->get_record_single(array('email' => $_POST['email']), '*');
            if (!empty($user_record)) {
                $this->common_model->initialise('hashurl');
                $code = hash('sha512', hash('md5', $_POST['email']) . hash('md5', date('ymdHis')));
                $this->common_model->array = array('user_id' => $user_record->id, 'hashcode' => $code, 'type' => 1);
                $hashcode = $this->common_model->insert_entry();
                $data['response'] = true;
                $data['info']['success'] = "Password changed sucessfully, mail sent to you";
                $this->load->model('communication_model');
                $this->communication_model->send_recover_code(array('email' => $_POST['email'], 'message' => $code, 'firstname' => $user_record->firstname));
            } else {
                $data['error'] = 'Not registered with us';
            }
        } else {
            $this->api_model->response(array('error' => 'No content'), 204);
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function changepassword() {
        date_default_timezone_set('America/Los_Angeles');
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data['response'] = false;
        if (!empty($_POST) && !empty($_POST['user_id'])) {
            $this->common_model->initialise('users');
            $user_record = $this->common_model->get_record_single(array('id' => $_POST['user_id']), '*');
            if (!empty($user_record)) {
                if (!empty($_POST['n_password']) && !empty($_POST['c_password'])) {
                    if ($_POST['n_password'] == $_POST['c_password']) {
                        $this->common_model->array = array('password' => $_POST['n_password']);
                        if ($this->common_model->update(array('id' => $_POST['user_id'])) == 0) {
                            $data['response'] = true;
                            $data['info']['message'] = "Successfully changed password";
                        }
                    } else {
                        $data['error'] = 'new and confirm password dont match';
                    }
                }
                if (!empty($_POST['nf_password']) && !empty($_POST['cf_password']) && $_POST['user_type'] == 4) {
                    if ($_POST['nf_password'] == $_POST['cf_password']) {
                        $this->common_model->initialise('merchant');
                        $this->common_model->array = array('passcode' => $_POST['nf_password']);
                        if ($this->common_model->update(array('user_id' => $_POST['user_id'])) == 0) {
                            $data['response'] = true;
                            $data['info']['message'] = "Successfully changed offer password";
                        }
                    } else {
                        $data['error'] = 'offer new and confirm password dont match';
                    }
                }
            } else {
                $data['error'] = 'Not registered with us';
            }
        } else {
            $this->api_model->response(array('error' => 'No content'), 204);
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function devicelogs() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $required_feilds = array('deviceid', 'UDID', 'make', 'model', 'os', 'osversion', 'userid');
        foreach ($required_feilds as $key => $value) {
            (empty($_POST[$value])) ? $data['error'][$value] = "$value should not be empty" : $data_array[$value] = $_POST[$value];
        }
        if (empty($data['error'])) {
            $emid = $this->common_model->storeprocedure("DeviceLog()");
            if (!empty($emid)) {
                $data_array['id'] = $emid[0]->id;
            }
            $this->common_model->initialise('devicelogs');
            $where = array('deviceid' => $_POST['deviceid'], 'UDID' => $_POST['UDID'], 'userid' => $_POST['userid']);
            $userc = $this->common_model->get_record_single($where, '*');
            if (empty($userc)) {
                $this->common_model->array = $data_array;
                $insert = $this->common_model->insert_entry();
                (!empty($insert)) ? $data['info'] = "Logs Inserted Sucessfully" : $data['error'] = "check the query";
            } else {
                $this->common_model->array = array('datemodified' => date('Y-m-d H:s:i'), 'make' => $_POST['make']);
                $insert = $this->common_model->update($where = array('deviceid' => $_POST['deviceid'], 'UDID' => $_POST['UDID'], 'userid' => $_POST['userid']));
                $data['info'] = "Logs updated sucessfully";
            }
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function login_log($id, $type, $action) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        if ($this->log_login_para($id, $type, $action)) {
            $output = $this->api_model->json(array('info' => 'sucess'), true);
            echo $output;
        }
        //}
//
//        fclose($fp);
    }

    private function log_login_para($id, $type, $action, $app_version = 0) {
        $flag = false;
        $type_name = 'Customer';
        $action_name = "Login";
        if ($type == 4) {
            $type_name = 'Merchant';
        }
        if ($action == 2) {
            $action_name = "Logout";
        }else{
            $this->common_model->initialise('accesslogs');
            $this->common_model->array = ['user_id' => $id,'sessionid' => $type_name,'processid' => $action];
            $this->common_model->insert_entry();
        }
        $url_to_save = "log/login/" . date('Y-m-d');
        if (!is_dir(FCPATH . $url_to_save)) {
            mkdir(FCPATH . $url_to_save, 0777, true);
            chmod(FCPATH . $url_to_save, 0777);
        }
        $fp = fopen(FCPATH . $url_to_save . "/log_login.csv", 'a');
        //chmod(FCPATH . $url_to_save . "/log_login.csv", 0777);
        //$file = fopen(FCPATH . $url_to_save . "/log_login.csv", "r");
        $row = 1;
        if (($handle = fopen(FCPATH . $url_to_save . "/log_login.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($data[0] == $id && $data[1] == $type_name && $data[3] == date('Y-m-d')) {
                    $flag = true;
                }
            }
            fclose($handle);
        }
        if (!$flag) {
            $this->log_login($type);
        }
        $list = array($id, $type_name, $action_name, date('Y-m-d'), date('H:s:i'), $app_version);
        //foreach ($list as $fields) {
        fputcsv($fp, $list);
        return true;
    }

    public function test() {
        $this->send_push(5, "Added Offer");
        $this->send_notifications('bebdf512a60f8db77c8b0e4c4650dd76d9af4dbae6740d5a3e1c8826a150f3bc', 'This is a test message', array('request_id' => 1));
    }

    public function activitylist($id, $user_type, $sort_type) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $group_by ="";
        $data = array();
//        $this->common_model->initialise('ichekpointsforactivity');
//        $where = "type <> 1 AND type <> 3 AND type <> 12";
        if ($user_type == 4) {
            $user_where = " id_merchant = $id";
            $this->common_model->initialise('followers');
            $follow_count = $this->common_model->get_record_single("id_user = $id", "COUNT(*) as cnt");
            $data['info']['follow_count'] = $follow_count->cnt;
            $data['info']['follow_count'] = count($this->common_model->storeprocedure("FollowerList({$id})"));
            $this->common_model->initialise('ichekpointsforactivity');
            $review_count = $this->common_model->get_record_single("id_merchant = $id AND type = 7", "COUNT(*) as cnt");
            $data['info']['review_count'] = $review_count->cnt;
        } else {
            $user_where = " id_customer = $id";
            if ($sort_type == 2) {
                $this->common_model->initialise('followers');
                $where = array('id_follower' => $id);
                $get_follow_details = $this->common_model->get_record_single($where, 'group_concat(concat(id_user)) as ids');

                if (empty($get_follow_details->ids)) {
                    $user_where = "id_merchant in (0)";
                } else {
                    $user_where = "id_merchant in ($get_follow_details->ids)";
                }
            }
        }
        if (empty($sort_type)) {
            $sort_type = '14,2,7,9,13,11';
        }

        if(!empty($sort_type) && $sort_type == 10){
            $sort_type = '10,9';
            $group_by = "GROUP BY id_customer";
        }
        //$activity_details = $this->common_model->get_records(25, array("DATE_FORMAT(datecreated,'%e') as day,DATE_FORMAT(datecreated,'%b %y') as month,activity,activity_id, type"), $where, 'datecreated');
        $qry = "SELECT DATE_FORMAT(IcPA.datecreated,'%e') as day,DATE_FORMAT(IcPA.datecreated,'%b %y') as month,activity,activity_id, type, activity_sub,
if(OF.status = 1, OF.status,0) as offer_status
FROM (`tbl_ichekpointsforactivity` as IcPA)
LEFT JOIN tbl_offers OF ON ((IcPA.type=14 OR IcPA.type = 7 OR IcPA.type = 9 OR IcPA.type = 2 OR IcPA.type = 13) AND OF.status = 1 AND OF.id = IcPA.activity_id)
WHERE `type` <> 1 AND type <> 3 AND type <> 12 AND $user_where AND type in ($sort_type) $group_by
ORDER BY IcPA.`datecreated` desc
LIMIT 25";
        $activity_details = $this->common_model->pureQuery($qry);
        if (!empty($activity_details)) {
            $data['info']['activity_details'] = $activity_details;
        } else {
            $data['error'] = "No Activities";
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function cashout() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $iset = $this->ichecksettings();
        if (($_POST['amount'] >= $iset->cashout_min_points) && ($_POST['amount'] <= $iset->max_cash_out)) {
            $user_record = $this->check_user(array('id' => $_POST['user_id'], 'cash >=' => $_POST['amount']));
            if (!empty($user_record)) {
                if ($paypal_R = $this->cash($this->router->fetch_method(), $user_record, $_POST['email']) == 'Success') {
                    $data['info'] = 'SuUp';
                } else {
                    $data['error'] = $paypal_R;
                }
            } else {
                $data['error'] = "Insufficient Funds";
            }
        } else {
            $data['error'] = "Please enter Right Amount";
        }
        echo $output = $this->api_model->json($data, true);
    }

    public function topup() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $user_record = $this->check_user(array('id' => $_POST['user_id']));
        if (!empty($user_record)) {
            if ($this->cash($this->router->fetch_method(), $user_record) == 0) {
                $data['info'] = 'SuUp';
            }
        } else {
            $data['error'] = "NoU";
        }
        echo $output = $this->api_model->json($data, true);
    }

//send message
    public function sendmessage() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $data_array = array();
        $msg_array = array();
        if (!empty($_POST) && !empty($_POST['user1']) && !empty($_POST['user2'])) {
            if (!is_numeric($_POST['user1']) || !is_numeric($_POST['user2'])) {
                $data['error'] = "please enter proper user id";
            }
            $data_array = $_POST;
            unset($data_array['message']);
            unset($data_array['user_type']);
//print_r($data_array); exit;
            if (empty($data['error'])) {
                $this->common_model->initialise('messageuserlink');
                $where = '(user1 = ' . $_POST['user1'] . ' AND user2 = ' . $_POST['user2'] . ') OR (user2 = ' . $_POST['user1'] . ' AND user1 = ' . $_POST['user2'] . ')';
                $row = $this->common_model->get_record_single($where, 'COUNT(*) as count, messagelink_id');
                if ($row->count) {
                    $messagelink_id = $row->messagelink_id;
                } else {
                    $this->common_model->array = $this->trim_addslashes($data_array);
                    $messagelink_id = $this->common_model->insert_entry();
                }
                if (!empty($_POST['message'])) {
                    if (!empty($_POST['user_type']) && $_POST['user_type'] == 4) {
                        $user_type_post = 4;
                    } else {
                        $user_type_post = 5;
                    }
                    $msg_array = array('messagelink_id' => $messagelink_id, 'user_id' => $_POST['user1'], 'message' => $_POST['message'], 'user_type' => $user_type_post);
                    $this->common_model->initialise('messages');
                    $old_records = $this->common_model->get_records(1, "*", "messagelink_id = $messagelink_id", 'datecreated', 'asc', 'messagelink_id', 'count(messagelink_id) > 25');
                    $this->common_model->array = $msg_array;
                    $result = $this->common_model->insert_entry();
                    if (!empty($old_records)) {
                        $old_records = (array) $old_records[0];
                        $this->message_log($messagelink_id, $old_records);
                        $this->common_model->array = $old_records;
                        $this->common_model->delete_record();
                    }
                }
                $this->common_model->initialise('user_types');
                $user_type = $this->common_model->get_record_single(array("user_id" => $_POST['user1']), "user_type");
                $user_type1 = $this->common_model->get_record_single(array("user_id" => $_POST['user2']), "user_type");
                $points = $this->get_points($this->router->fetch_method());
                $user_details = $this->check_user(array('id' => $_POST['user1']));
                if (!empty($_POST['user_type']) && $_POST['user_type'] == 4) {
                    $this->common_model->initialise('merchant');
                    $merchant_details = $this->common_model->get_record_single(array("user_id" => $_POST['user1']), "display_name");
                    $form_name = $merchant_details->display_name;
                } else {
                    $form_name = $user_details->firstname;
                }
//                if ($user_type->user_type == 4) {
//                    $merchant = $_POST['user1'];
//                } else {
//                    $customer = $_POST['user1'];
//                }
                $merchant = $customer = 0;
                if ($user_type1->user_type == 4) {
                    $merchant = $_POST['user2'];
                } else {
                    $customer = $_POST['user2'];
                }
                $this->pointsforactivities(array("$points->activity_name", "From $form_name"), $messagelink_id, $points->id, $points->activity_points, $users = array('id_customer' => $customer, 'id_merchant' => $merchant));
                $data['info']['messagelink_id'] = $messagelink_id;
                $data['info']['message'] = 'MSS';
            }
        } else {
            $this->api_model->response('', 204);
        }
        $output = $this->api_model->json($data);
//$this->log($_POST['user_id'], array($_POST['user_id'], 'merchant', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

//messages-list
    public function getmessages($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
//        $this->common_model->initialise('messageuserlink');
//        $where = 'user1 = ' . $id . ' OR user2 = ' . $id;
//        $result = $this->common_model->get_records(0, 'messagelink_id', $where);
//        $ids = implode(',', array_map('current', $result));
//print_r($ids);
        $result = $this->common_model->storeprocedure("MessageList({$id})");
        if (!empty($result)) {
//            $where = "messagelink_id IN ($ids) AND user_id != " . $id;
//            $where = "messagelink_id IN ($ids)";
//            $this->common_model->initialise('messages as ME');
//            $this->common_model->join_tables = "users as U";
//            $this->common_model->join_on = "ME.user_id = U.id";
//            $data['info'] = $this->common_model->get_records(0, array('*', "DATE_FORMAT(ME.datecreated,'%e') as day", "DATE_FORMAT(ME.datecreated,'%b %y') as monthyear"), $where, 'datecreated', 'desc', 'messagelink_id');
            $data['info'] = $result;
        } else {
            $data['error'] = "NMSG";
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

//messages-conversations
    public function conversations($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $where = "messagelink_id = " . $id;
        $this->common_model->initialise('messages');
        // $data['info']['conversations'] = $this->common_model->get_records(0, '*', $where, 'datecreated', 'ASC');
        $data['info']['conversations'] = $this->common_model->get_records(0, array('*', "DATE_FORMAT(datecreated,'%e %b %Y %H:%i:%s') as date"), $where, 'datecreated', 'ASC');
        $this->common_model->initialise('messageuserlink as MSL');
        $this->common_model->join_tables = array('user1' => 'users as U1', 'user2' => 'users as U2');
        $this->common_model->join_on = array('user1' => 'MSL.user1 = U1.id', 'user2' => 'MSL.user2 = U2.id');
        $data['info']['users_details'] = $this->common_model->get_record_single($where, array("U1.id as user1_id", "U2.id as user2_id", "CONCAT(U1.firstname,' ', U1.lastname) as user1_name", "CONCAT(U2.firstname,' ', U2.lastname) as user2_name"));
        if (empty($data)) {
            $data['messages'] = 0;
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function summary_count($id, $user_type) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $result = $this->common_model->storeprocedure("MessageListCount({$id})");
        if (!empty($user_type) && $user_type == 4) {
            $follow_list = $this->common_model->storeprocedure("FollowerList({$id})");
            $this->common_model->initialise('offers');
            $where = array('user_id' => $id, 'status' => 1);
            $offers = $this->common_model->get_record_single($where, "count(*) as cnt");
            $this->common_model->initialise('offers as OF');
            $this->common_model->join_tables = array('offerreviews as  OFR','review_messages as RM');
            $this->common_model->join_on = array("OF.id = OFR.id_offer",'OFR.id = RM.review_id AND RM.user_type = 5 AND RM.view_status = 0');
            $where = array('OF.user_id' => $id);
            $reviews_list = $this->common_model->get_record_single($where, 'count(OF.id) as cnt');
            !empty($follow_list) ? $data[' follow_count'] = count($follow_list) : $data[' follow_count'] = 0;
            !empty($offers->cnt) ? $data['offers_count'] = $offers->cnt : $data['offers_count'] = 0;
            !empty($reviews_list->cnt) ? $data['review_count'] = $reviews_list->cnt : $data['review_count'] = 0;
        } else {
            $merchant_id = $this->common_model->storeprocedure("CustomerSavedOffersN({$id})");
            $friends_list = $this->common_model->storeprocedure("FriendsList({$id},1)");
            $this->common_model->initialise('friends');
            $where = array('to_user_id' => $id, 'status' => 0);
            $invites_list = $this->common_model->get_record_single($where, "count(*) as cnt");
            $this->common_model->initialise('offerreviews as  OFR');
            $this->common_model->join_tables = array('review_messages as RM');
            $this->common_model->join_on = array("OFR.id = RM.review_id AND RM.user_type = 4 AND RM.view_status = 0");
            $where = array('OFR.id_customer' => $id);
            $reviews_list = $this->common_model->get_record_single($where, 'count(*) as cnt');
            !empty($merchant_id) ? $data['saved_offers_count'] = count($merchant_id) : $data['saved_offers_count'] = 0;
            !empty($friends_list) ? $data['friends_count'] = count($friends_list) : $data['friends_count'] = 0;
            !empty($invites_list->cnt) ? $data['invites_count'] = $invites_list->cnt : $data['invites_count'] = 0;
            !empty($reviews_list->cnt) ? $data['review_count'] = $reviews_list->cnt : $data['review_count'] = 0;
        }
        !empty($result) ? $data['inbox_count'] = count($result) : $data['inbox_count'] = 0;
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function test2() {

        //echo 'sada';
        //$access_token = $this->paypal();
        $this->send_push(2, 'Received review', array('review_id' => 2));

        //$this->payout($access_token, 2, 'omichek-user2@gmail.com', $senderid = date('YmdHsi'));
    }

    public function test3() {
       // print_r($data);
    }

    public function friendDetails($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $this->common_model->initialise('user_types');
        $da_ar = $this->common_model->get_records(0, 'user_type', array('user_id' => $id));
        $data['info']['user_type'] = $this->change_array($da_ar);
        if ($data['info']['user_type'][0] == 4) {
            $data['info'] = $this->common_model->storeprocedure("MerchantDetails({$id})");
        } else {
            $data['info'] = $this->common_model->storeprocedure("CustomerDetails({$id})");
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function friendstatus($id, $status) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $this->common_model->initialise('friends');
        $this->common_model->array = array('status' => $status);
        if ($this->common_model->update(array('id' => $id)) == 0) {
            $dt = $this->common_model->get_record_single(array('id' => $id), '*');
            $this->common_model->initialise('users');
            $dts = $this->common_model->get_record_single(array('id' => $dt->to_user_id), 'firstname');
            $this->send_push($dt->from_user_id, 'Invitation accepted successfully', array('friend_id' => $dt->id, 'friend_name' => $dts->firstname));
            $data['info']['message'] = "SuUp";
        } else {
            $data['error']['message'] = "Prb";
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function feedback() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('general');
        $this->common_model->array = array('column1' => $_POST['user_id'], 'column2' => $_POST['message'], 'type' => 2, 'status' => 0);
        $result = $this->common_model->insert_entry();
        if (!empty($result)) {
            $data['info'] = "Thanks for your feedback";
        } else {
            $data['error'] = "Try again";
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function categories() {
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $this->common_model->initialise('categories');
        $cat = $this->common_model->get_records(0, '*', array('status' => 1));
        if (!empty($cat)) {
            $data['info']['categories'] = $cat;
        } else {
            $data['error'] = "There are no Categories";
        }
        $output = $this->api_model->json($data, true);
        //$this->log($id, array($id, 'customer', $this->router->fetch_method(), date('Y-m-d H:i:s'), $output));
        echo $output;
    }

    public function get_reviewdetails($id) {
        if ($this->input->server('REQUEST_METHOD') != 'GET') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        $where = array('R.id' => $id); //review_id
        $review = $this->reviewinfo($where);
        if (!empty($review)) {
            $data['response'] = TRUE;
            $data['info']['main_review'] = (array) $review;
            $this->common_model->initialise('review_messages');
            $data['info']['sub_review'] = $this->common_model->get_records(0, $select = array('user_type', 'message'), $where = array('review_id' => $id, 'review_type' => 0), 'datecreated', 'ASC');
            (!empty($rating)) ? $data['info']['rating'] = $rating->rating : $data['info']['rating'] = $review->rating;
        } else {
            $data['response'] = FALSE;
            $data['error'] = 'No reviews found';
            $data['info']['message'] = 'No reviews found';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function updategeo($id) {
        if ($this->input->server('REQUEST_METHOD') != 'POST') { /* checks wehter it is a POST or GET */
            $this->api_model->response('', 406);
        }
        $data = array();
        if (!empty($_POST['lat']) && !empty($_POST['lng'])) {
            $data_array = $_POST;
            $this->common_model->initialise('merchant');
            $this->common_model->array = $this->trim_addslashes($data_array);
            if ($this->common_model->update(array('user_id' => $id)) == 0) {
                $data['info']['message'] = 'Updated Successfully';
            } else {
                $data['error'] = 'Try Again';
            }
        } else {
            $data['error'] = 'Insufficient Data';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function geofence() {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->api_model->response('', 406);
        }
        $data = array();
        $required_feilds = array('udid', 'lat', 'long', 'location', 'btype', 'type', 'datecreated');
        foreach ($required_feilds as $key => $value) {
            if (empty($_POST[$value])) {
                $data['error'][$value] = "$value should not be empty";
            } else {
                $data_array[$value] = $_POST[$value];
            }
        }
        if (empty($data['error'])) {
            $this->common_model->initialise('geofence');
            $this->common_model->array = $data_array;
            $insert = $this->common_model->insert_entry();
            (!empty($insert)) ? $data['info'] = "Logs Inserted Sucessfully" : $data['error'] = "check the query";
        }
        $output = $this->api_model->json($data, true);
        echo $output;
    }

    public function reviewstatus($review_id,$user_type){
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        if (!empty($review_id) && !empty($user_type)) {
            $this->change_review_view_status($review_id,$user_type);
            $data['info']['message'] = 'Updated Successfully';
        } else {
            $data['error'] = 'Insufficient Data';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

    public function messagestatus($message_link_id,$user_id){
        if ($this->input->server('REQUEST_METHOD') != 'GET') {
            $this->api_model->response('', 406);
        }
        if (!empty($message_link_id) && !empty($user_id)) {
            $this->change_message_view_status($message_link_id,$user_id);
            $data['info']['message'] = 'Updated Successfully';
        } else {
            $data['error'] = 'Insufficient Data';
        }
        $output = $this->api_model->json($data);
        echo $output;
    }

}
