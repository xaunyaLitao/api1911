<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function hello()
    {
        echo "大傻逼";
    }


    // 获取access_token
    public function WXtoken()
    {
        $appid="wxc8e73af28fb246ce";
        $appsecret="e3b11750e1de175e6f94cde4ebdfed72";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $cont=file_get_contents($url);
        echo $cont;
    }
}
