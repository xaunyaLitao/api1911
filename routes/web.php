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


Route::get('test1','TestController@test1');
Route::get('/info','TestController@info');

// 注册
Route::get('index/reg','Index\LoginController@reg');
Route::post('index/regdo','Index\LoginController@regdo');


//登录
Route::get('index/login','Index\LoginController@login');

Route::get('index/center','Index\LoginController@center');

