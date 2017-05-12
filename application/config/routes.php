<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$urlsegment = $_SERVER["REQUEST_URI"];
$urlsegment = explode('/', trim($urlsegment, '/'));
$route['default_controller'] = "frontend";
//print_r($urlsegment); exit;
if (empty($urlsegment[1])) {
    $urlsegment[1] = 0;
}
if ($urlsegment[0] == 'Admin' || $urlsegment[1] == 'Admin') {
    $url_se = ($urlsegment[0] == 'Admin') ? $urlsegment[0] : $urlsegment[1];
    $route['Admin'] = "{$url_se}/users";
    $route['Admin/users'] = "{$url_se}/admin/users";
    $route['Admin/useradd'] = "{$url_se}/admin/add";
    $route['Admin/useredit/(:num)'] = "{$url_se}/admin/edit/$1";
    $route['Admin/userdelete/(:num)'] = "{$url_se}/admin/delete/$1";
    $route['Admin/logout'] = "{$url_se}/admin/logout";
}

$route['404_override'] = '';
$route['apisignup'] = "api/signup";
$route['apilogin'] = "api/login";
$route['apis_signup'] = "api/s_signup";
$route['apiforgotpassword'] = "api/forgotpassword";
$route['apichangepassword'] = "api/changepassword";
$route['apidevicelogs'] = "api/devicelogs";
$route['apiloginlog/(:num)/(:num)/(:num)'] = "api/login_log/$1/$2/$3";
$route['apifeedback'] = "api/feedback";
$route['apicategories'] = "api/categories";
$route['apiupdategeo/(:num)'] = "api/updategeo/$1";
$route['apireviewstatus/(:num)/(:num)'] = "api/reviewstatus/$1/$2";
$route['apimessagestatus/(:num)/(:num)'] = "api/messagestatus/$1/$2";



$route['apimerchantedit'] = "apimerchant/edit";
$route['apimerchantaddoffer'] = "apimerchant/add_offer";
$route['apimerchantupdateoffer'] = "apimerchant/update_offer";
$route['apimerchantoffers/(:num)'] = "apimerchant/get_offers/$1";
$route['apimerchantdetails/(:num)'] = "apimerchant/details/$1";
$route['apimerchantbalance/(:num)'] = "apimerchant/get_balance/$1";
$route['apimerchantofferdetails/(:num)'] = "apimerchant/offerdetails/$1";
$route['apimerchantaddress'] = "apimerchant/update_address";
$route['apimerchantimages'] = "apimerchant/update_images";
$route['apimerchanthoursimages'] = "apimerchant/business_hours_images";
$route['apimerchantdeleteoffer/(:num)'] = "apimerchant/delete_offer/$1";
$route['apimerchantaddreview/(:num)'] = "apimerchant/addreview/$1";
$route['apimerchantreviews/(:num)'] = "apimerchant/get_reviews/$1";
$route['apimerchantreviewdetails/(:num)'] = "api/get_reviewdetails/$1";
$route['apimerchantreviewreport/(:num)'] = "apimerchant/reviewreport/$1";
$route['apimerchantfollowlist/(:num)'] = "apimerchant/followlist/$1";
$route['apimerchantfollowerdetails/(:num)/(:num)'] = "apimerchant/followerdetails/$1/$2";
$route['apimerchantmessagelist/(:num)'] = "api/messagelist/$1";
$route['apimerchantactivitylist/(:num)/(:num)/(:num)'] = "api/activitylist/$1/$2/$3";
$route['apimerchantsendmessage'] = "api/sendmessage";
$route['apimerchantmessages/(:num)'] = "api/getmessages/$1";
$route['apimerchantconversations/(:num)'] = "api/conversations/$1";
$route['apimerchantcashout'] = "api/cashout";
$route['apimerchanttopup'] = "api/topup";
$route['apimerchantfollwersofferdetails/(:num)/(:num)'] = "apimerchant/follwersofferdetails/$1/$2";
$route['apimerchantpaypaldetails/(:num)/(:num)/(:num)'] = "api/paypal_update/$1/$2/$3";
$route['apimerchantresendoffer/(:num)'] = "apimerchant/resendoffer/$1";
$route['apimerchantfriendstatus/(:num)/(:num)'] = "api/friendstatus/$1/$2";
$route['apimerchantrreply/(:num)'] = "apimerchant/r_reply/$1";
$route['apimerchantemailblast/(:num)'] = "apimerchant/emailblast/$1";



$route['apicustomerview/(:num)'] = "apicustomer/view/$1";
$route['apicustomeredit'] = "apicustomer/edit";

$route['apicustomerredeem'] = "apicustomer/redeem";
$route['apicustomerredeemedoffers/(:num)/(:num)'] = "apicustomer/redeemedoffers/$1";
$route['apicustomeroffer/(:num)/(:num)'] = "apicustomer/offer/$1/$2";
//$route['apicustomeroffer/(:num)'] = "apicustomer/offer/$1";
$route['apicustomeroffers/(:num)/(:num)'] = "apicustomer/offers/$1/$2";
$route['apicustomeraddreview/(:num)'] = "apicustomer/addreview/$1";
$route['apicustomerrreply/(:num)'] = "apicustomer/r_reply/$1";
$route['apicustomerreviewslist/(:num)'] = "apicustomer/reviewslist/$1";
$route['apicustomerreviewdetails/(:num)'] = "api/get_reviewdetails/$1";
$route['apicustomersavedoffers/(:num)/(:num)'] = "apicustomer/savedoffers/$1";
$route['apicustomersaveoffer/(:num)/(:num)'] = "apicustomer/saveoffer/$1/$2";
$route['apicustomerdeletesavedoffer/(:num)'] = "apicustomer/deletesavedoffer/$1";
$route['apicustomerdod'] = "apicustomer/dod";
$route['apicustomermerchantdetails/(:num)'] = "apimerchant/details/$1";
$route['apicustomersendoffertofriend/(:num)/(:num)'] = "apicustomer/sendoffertofriend/$1/$2";


$route['apicustomernearbussiness/(:num)'] = "apicustomer/nearbussiness/$1";
$route['apicustomerfollowus/(:num)/(:num)'] = "apicustomer/followus/$1/$2";
$route['apicustomerfollowlist/(:num)'] = "apicustomer/followlist/$1";
$route['apicustomerbusiness/(:any)/(:any)/(:num)'] = "apicustomer/get_business/$1/$2/$3";
$route['apicustomerinvitebusiness/(:num)/(:num)'] = "apicustomer/invite_business/$1/$2";
$route['apicustomermerchantinfo/(:any)/(:any)'] = "apicustomer/merchantinfo/$1/$2";
$route['apicustomerallbusiness/(:any)/(:any)/(:any)'] = "apicustomer/get_all_business/$1/$2/$3";
$route['apisearchbusiness'] = "apicustomer/search_business";

//$route['apicustomermessagelist/(:num)'] = "api/messagelist/$1";
$route['apicustomeractivitylist/(:num)/(:num)/(:num)'] = "api/activitylist/$1/$2/$3";

$route['apicustomerinvitefriend'] = "apicustomer/invitefriend";
$route['apicustomerfriendslist/(:num)/(:num)'] = "apicustomer/friendslist/$1/$2";
$route['apicustomerfrienddetails/(:num)'] = "api/friendDetails/$1";
$route['apicustomersendmessage'] = "api/sendmessage";
$route['apicustomermessages/(:num)'] = "api/getmessages/$1";
$route['apicustomerconversations/(:num)'] = "api/conversations/$1";
$route['apicustomercashout'] = "api/cashout";
$route['apicustomerpaypaldetails/(:num)/(:num)/(:num)'] = "api/paypal_update/$1/$2/$3";
$route['apicustomerfriendstatus/(:num)/(:num)'] = "api/friendstatus/$1/$2";
$route['apicustomerproximity'] = "apicustomer/get_proximal";
$route['apicustomeroffersnew'] = "apicustomer/offersnew";
$route['apicustomer_invited_business/(:num)'] = "apicustomer/customer_invited_business/$1";
$route['apisummarycount/(:num)/(:num)'] = "api/summary_count/$1/$2";







/* End of file routes.php */
/* Location: ./application/config/routes.php */
