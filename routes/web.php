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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route generate halaman register berdasarkan referral link
Route::get('/ref/{rand}','ReferralController@refer');

//Route verifyemail
Route::get('/verifyemail/{cryptedcode}','Auth\LoginController@verifyemail');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web','auth']], function() {

  //Referral
  Route::get('/referral','ReferralController@index');
  Route::get('/referral/load-referral','ReferralController@load_referral');

  //History Search
  Route::get('/history-search','AccountController@index_history');
  Route::get('/history-search/load-history-search','AccountController@load_history_search');
  Route::get('/history-search/print-pdf/{id}','AccountController@print_pdf');
  Route::get('/history-search/print-csv/{id}','AccountController@print_csv');
  Route::get('/history-search/get-groups','AccountController@get_groups');
  Route::get('/history-search/add-groups','AccountController@add_groups');
  Route::get('/history-search/create-groups','AccountController@create_groups');

  //Edit Profile
  Route::get('/edit-profile','ProfileController@index_edit');
  Route::post('/edit-profile/edit','ProfileController@edit_profile');

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
  Route::get('/compare-history/print-pdf/{id}','CompareController@print_pdf');
  Route::get('/compare-history/print-csv/{id}','CompareController@print_csv');

  //Groups
  Route::get('/groups','GroupController@index');
  Route::get('/groups/load-groups','GroupController@load_groups');
  Route::get('/groups/{id}/{group_name}','GroupController@index_list');
  Route::get('/groups/load-list-group','GroupController@load_list_group');

  //Saved Profile
  Route::get('/saved-profile','GroupController@index_saved');
  Route::get('/saved-profile/load-accounts','GroupController@load_saved_accounts');

  //Notification 
  Route::get('/notifications','NotificationController@index');
});

//Search
  Route::get('/search','AccountController@index');
  Route::get('/search/load-search','AccountController@load_search');
  Route::get('/search/load-history','AccountController@load_history');  
  Route::get('/search/delete-history','AccountController@delete_history');

