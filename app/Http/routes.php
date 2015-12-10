<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Blade::setContentTags('@{{', '}}');         // for variables and all things Blade
//Blade::setEscapedContentTags('<%%', '%%>');     // for escaped data
Route::get('/', function () {
    return view('welcome');
});

Route::get('user/index/{status?}','UserController@index');
Route::post('user/store','UserController@store');
Route::post('user/leave','UserController@leave');
Route::post('user/upwd','UserController@upwd');

Route::get('log/index','LogController@index');

Route::get('ticket/index','TicketController@index');
Route::get('ticket/appGetMaintianWorkFormAct','TicketController@appGetMaintianWorkFormAct');
Route::post('ticket/check','TicketController@check');
Route::post('ticket/clearCheck','TicketController@clearCheck');
Route::post('ticket/delCheck','TicketController@delCheck');
Route::get('ticket/show/{id}','TicketController@show');
Route::get('ticket/nhdata/{id}','TicketController@nhdata');
Route::get('ticket/ebsdata/{id}','TicketController@ebsdata');

Route::get('ticket/ebs','TicketController@ebs');
Route::post('ticket/ebspost','TicketController@ebspost');
Route::post('ticket/ebslog','TicketController@ebslog');
Route::post('ticket/ebscallback','TicketController@ebscallback');

Route::get('setting/index','SettingController@index');
Route::post('setting/usn','SettingController@usn');
Route::post('setting/usend','SettingController@usend');
Route::post('setting/ucrm','SettingController@ucrm');
Route::post('setting/utime','SettingController@utime');

Route::post('nhserver/store','NhserverController@store');
Route::post('nhserver/update','NhserverController@update');
