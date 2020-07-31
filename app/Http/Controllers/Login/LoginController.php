<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
//    注册的视图
public function reg()
{
    return view('login/reg');
}



//    登录的视图
    public function login()
    {
        return view('login/login');
    }

//    个人中心视图
    public function center()
    {
        return view('login/center');
    }
}
