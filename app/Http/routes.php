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

Route::get('order/index','OrderController@index');
Route::get('order/appGetMaintianWorkFormAct','OrderController@appGetMaintianWorkFormAct');
