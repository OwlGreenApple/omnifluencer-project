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

  //Search
  Route::get('/search','AccountController@index');
  Route::get('/search/load-search','AccountController@load_search');
  Route::get('/search/load-history-search','AccountController@load_history_search');  
  Route::get('/search/delete-history','AccountController@delete_history');
});

