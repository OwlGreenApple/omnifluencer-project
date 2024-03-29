<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Tes
Route::get('/tes-igcallback', 'TesController@tes_igcallback');
Route::get('testmail', 'ApiController@testmail');

//Auth
Route::post('register', 'Auth\RegisterController@register')->middleware('checkwa');
Route::post('post-register', 'Auth\RegisterController@post_register')->middleware('checkwa');
Route::post('register/cek-email', 'Auth\RegisterController@cek_email');


//API 
Route::post('generate-coupon', 'ApiController@generate_coupon');
Route::post('sendmailfromactivwa', 'ApiController@sendmailfromactivwa');

//Home
Route::get('/home', 'AccountController@index')
      ->name('home');
Route::get('/', 'AccountController@index');

//Search
Route::get('/search','AccountController@index_post');
Route::get('/search/load-search','AccountController@load_search');
Route::get('/search/load-search-byid','AccountController@load_search_byid');
Route::get('/search/load-history','AccountController@load_history');  
Route::get('/search/delete-history','AccountController@delete_history');

//Route generate halaman register berdasarkan referral link
Route::get('/ref/{rand}','ReferralController@refer');

Route::post('login', 'Auth\LoginController@login')->name('login');
//Route verifyemail
Route::get('/verifyemail/{cryptedcode}','Auth\LoginController@verifyemail');

//FAQ
Route::get('/faq','HomeController@index_faq');
Route::get('/about-us','HomeController@index_statics');
Route::get('/about-us/{page}','HomeController@index_statics_page');

//pricing
Route::get('/pricing','OrderController@pricing');
Route::get('/thankyou','OrderController@thankyou');
Route::get('/thankyou-free','OrderController@thankyou_free');
Route::get('/thankyou-ovo','OrderController@thankyou_ovo')->name('thankyouovo');
//Route::get('/checkout/pro-15hari','OrderController@checkout_free');
Route::get('/checkout/{id}','OrderController@checkout');

//payment
Route::post('/confirm-payment','OrderController@confirm_payment');
Route::post('/register-payment','OrderController@register_payment');
Route::post('/login-payment','OrderController@login_payment')->name('loginbuy');

//Auto Confirm
//Route::get('/testjson','AutoConfirmController@virtualRestApi');
Route::post('/autoconfirm','AutoConfirmController@confirm')->name('autoconfirm');

Route::post('/subscribe-email','AccountController@subscribe_email');

//Coupon
Route::post('check_coupon','OrderController@checkCoupon')->name('checkcoupon');

//User
Route::group(['middleware' => ['web','auth']], function() 
{
  //Compare 
  Route::get('/compare/','CompareController@index');
  Route::get('/compare/check','CompareController@check');
  Route::get('/compare/load-search','CompareController@load_search');
  Route::get('/compare/load-compare','CompareController@load_compare');
  Route::get('/compare/{keywords}','CompareController@index');
  Route::get('/click-compare','CompareController@click_compare');

  //Referral
  Route::get('/referral','ReferralController@index');
  Route::get('/referral/load-referral','ReferralController@load_referral');

  //History Search
  Route::get('/history-influencer','AccountController@index_history');
  Route::get('/history-search/load-history-search','AccountController@load_history_search');
  Route::get('/history-search/get-groups','AccountController@get_groups');
  Route::get('/history-search/add-groups','AccountController@add_groups');
  Route::get('/history-search/create-groups','AccountController@create_groups');
  Route::get('/history-search/save-groups','AccountController@save_groups');
  Route::get('/history-search/delete-history-bulk','AccountController@delete_history_bulk');

  //Edit Profile
  Route::get('/edit-profile','ProfileController@index_edit');
  Route::post('/edit-profile/edit','ProfileController@edit_profile');
  Route::get('/edit-profile/delete-photo','ProfileController@delete_photo');

  //Change Password
  Route::get('/change-password','ProfileController@index_changepass');
  Route::post('/change-password/change','ProfileController@change_password');

  //Dashboard 
  Route::get('/dashboard','ProfileController@index_dashboard');

  //Points 
  Route::get('/reward-points','PointController@index');  
  Route::get('/points/load-points','PointController@load_points'); 
  Route::get('/reward-points/{id}','PointController@index_redeem');
  Route::get('/redeem-point','PointController@redeem_point');

  //Upgrade Account 
  Route::get('/upgrade-account','OrderController@index_upgrade');  

  //Compare History
  Route::get('/compare-history','CompareController@index_history');
  Route::get('/compare-history/load-history-compare','CompareController@load_history_compare');
  Route::get('/compare-history/delete','CompareController@delete_compare');
  Route::get('/compare-history/delete-bulk','CompareController@delete_compare_bulk');

  //Groups
  Route::get('/groups','GroupController@index');
  Route::get('/groups/load-groups','GroupController@load_groups');
  Route::get('/groups/{id}/{group_name}','GroupController@index_list');
  Route::get('/groups/load-list-group','GroupController@load_list_group');
  Route::get('/groups/delete-member','GroupController@delete_member_group');
  Route::get('/groups/delete-member-bulk','GroupController@delete_member_group_bulk');
  Route::get('/groups/delete-group','GroupController@delete_group');
  Route::get('/groups/delete-single-group','GroupController@delete_single_group');
  Route::get('/groups/edit-group','GroupController@edit_group');
  Route::get('/groups/create-group','GroupController@create_group');

  //Saved Profile
  Route::get('/saved-profile','GroupController@index_saved');
  Route::get('/saved-profile/load-accounts','GroupController@load_saved_accounts');
  Route::get('/saved-profile/delete','GroupController@delete_saved_profile');
  Route::get('/saved-profile/delete-bulk','GroupController@delete_saved_profile_bulk');

  //Notification 
  Route::get('/notifications','NotificationController@index');

  //Download PDF CSV and Send To
  Route::get('/send_email','AccountController@send_email');
  Route::get('/print-pdf/{id}/{type}','AccountController@print_pdf');
  Route::get('/print-csv/{id}','AccountController@print_csv');
  Route::get('/send-email-compare','CompareController@send_email');
  Route::get('/print-pdf-compare/{id}/{type}','CompareController@print_pdf');
  Route::get('/print-csv-compare/{id}','CompareController@print_csv');
  Route::get('/print-pdf-bulk','AccountController@print_pdf_bulk');
  Route::get('/print-csv-bulk','AccountController@print_csv_bulk');
  Route::get('/send-email-bulk','AccountController@send_email_bulk');

  //Order
  Route::get('/billing','OrderController@index_order');
  Route::get('/orders/load-order','OrderController@load_order');
  Route::post('/orders/confirm-payment','OrderController@confirm_payment_order');
});

//Admin
Route::group(['middleware' => ['web','auth','admin']], function()
{
  Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
  
  Route::get('superadmin', 'UserController@super_admin');
  Route::get('loginuser/{id_user}', 'UserController@LoginUser');
  
  //List Order
  Route::get('/list-order','OrderController@index_list_order');
  Route::get('/list-order/load-order','OrderController@load_list_order');
  Route::get('/list-order/confirm','OrderController@confirm_order');

  //List Coupons
  Route::get('list-coupons','CouponController@index');
  Route::post('addcoupon','CouponController@addCoupon')->middleware('coupon')->name('addcoupon');
  Route::get('getcoupon','CouponController@getCoupon')->name('getcoupon');
  Route::get('getcoupontable','CouponController@getCouponTable')->name('getcoupontable');
  Route::post('updatecoupon','CouponController@updateCoupon')->middleware('coupon')->name('updateCoupon');
  Route::get('delcoupon','CouponController@delCoupon')->name('delCoupon');

  //List Transfers
  Route::get('list-transfers','AutoConfirmController@index');
  Route::get('list-getdatatransfer','AutoConfirmController@adminUserTransfer')->name('getdatatransfer');
  Route::get('list-getdetail','AutoConfirmController@adminDetailTransfer')->name('getdetail');

  //List User
  Route::get('/list-user','UserController@index');
  Route::get('/list-user/load-user','UserController@load_user');
  Route::get('/list-user/point-log','UserController@point_log');
  Route::get('/list-user/referral-log','UserController@referral_log');
  Route::get('/list-user/view-log','UserController@view_log');
  Route::post('/import-excel-user','UserController@import_excel_user');

  //List Accounts
  Route::get('/list-account','AccountController@index_account');
  Route::get('/list-account/load-account','AccountController@load_account');
  Route::get('/list-account/view-log','AccountController@view_account_log');
});

Route::get('logs-8877', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');