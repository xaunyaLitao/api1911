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
Route::post('index/login','Index\LoginController@login');

Route::get('index/center','Index\LoginController@center')->middleware('accesstoken','all','user');


// hash练习
Route::get('test/hash','TestController@hash');
Route::get('test/hash1','TestController@hash1');


Route::get('/test2','TestController@test2');



Route::get('/goods','TestController@goods')->middleware('verifycount');

Route::get('/infos','TestController@infos')->middleware('viewcount');


Route::get('/encr1','TestController@encr1');
Route::get('/enc2','TestController@enc2');

//签名
Route::get('/sign','TestController@sign');

Route::get('/test/sign2','TestController@sign2');

Route::get('/test/sign3','TestController@sign3');
Route::get('/test/header1','TestController@header1');



Route::get('/index/login','Login\LoginController@login');
Route::get('/index/reg','Login\LoginController@reg');
Route::get('/index/center','Login\LoginController@center');

Route::get('/test/pay','TestController@testPay');
Route::get('/pay','TestController@pay');