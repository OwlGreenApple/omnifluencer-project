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

//Auth
Route::post('post-register', 'Auth\RegisterController@post_register');

//Home
Route::get('/home', 'AccountController@index')
      ->name('home');
Route::get('/', 'AccountController@index');

//Search
Route::get('/search','AccountController@index');
Route::get('/search/load-search','AccountController@load_search');
Route::get('/search/load-history','AccountController@load_history');  
Route::get('/search/delete-history','AccountController@delete_history');

//Route generate halaman register berdasarkan referral link
Route::get('/ref/{rand}','ReferralController@refer');

//Route verifyemail
Route::get('/verifyemail/{cryptedcode}','Auth\LoginController@verifyemail');

//FAQ
Route::get('/faq','HomeController@index_faq');
Route::get('/statics','HomeController@index_statics');

//pricing
Route::get('/pricing','OrderController@pricing');
Route::get('/checkout/{id}','OrderController@checkout');
Route::post('/confirm-payment','OrderController@confirm_payment');
Route::get('/register-payment','OrderController@register_payment');

Route::post('/subscribe-email','AccountController@subscribe_email');

Route::group(['middleware' => ['web','auth']], function() 
{
  //Compare 
  Route::get('/compare/','CompareController@index');
  Route::get('/compare/check','CompareController@check');
  Route::get('/compare/load-search','CompareController@load_search');
  Route::get('/compare/load-compare','CompareController@load_compare');
  Route::get('/compare/{keywords}','CompareController@index');

  //Referral
  Route::get('/referral','ReferralController@index');
  Route::get('/referral/load-referral','ReferralController@load_referral');

  //History Search
  Route::get('/history-search','AccountController@index_history');
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
  Route::get('/points','PointController@index');  
  Route::get('/points/load-points','PointController@load_points'); 

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

  //Saved Profile
  Route::get('/saved-profile','GroupController@index_saved');
  Route::get('/saved-profile/load-accounts','GroupController@load_saved_accounts');
  Route::get('/saved-profile/delete','GroupController@delete_saved_profile');
  Route::get('/saved-profile/delete-bulk','GroupController@delete_saved_profile_bulk');

  //Notification 
  Route::get('/notifications','NotificationController@index');

  //Download PDF CSV and Send To
  Route::get('/send_email','AccountController@send_email');
  Route::get('/print-pdf/{id}','AccountController@print_pdf');
  Route::get('/print-csv/{id}','AccountController@print_csv');
  Route::get('/send-email-compare','CompareController@send_email');
  Route::get('/print-pdf-compare/{id}','CompareController@print_pdf');
  Route::get('/print-csv-compare/{id}','CompareController@print_csv');
  Route::get('/print-pdf-bulk','AccountController@print_pdf_bulk');
  Route::get('/print-csv-bulk','AccountController@print_csv_bulk');
  Route::get('/send-email-bulk','AccountController@send_email_bulk');
});

Route::group(['middleware' => ['web','auth','admin']], function()
{
  Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});