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
});

//Search
  Route::get('/search','AccountController@index');
  Route::get('/search/load-search','AccountController@load_search');
  Route::get('/search/load-history','AccountController@load_history');  
  Route::get('/search/delete-history','AccountController@delete_history');

