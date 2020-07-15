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


    public function WXtoken2()
    {
        $appid="wxc8e73af28fb246ce";
        $appsecret="e3b11750e1de175e6f94cde4ebdfed72";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;


       // 创建一个新cURL资源
        $ch = curl_init();

     // 设置URL和相应的选项
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // 抓取URL并把它传递给浏览器
    curl_exec($ch);

    // 关闭cURL资源，并且释放系统资源
    curl_close($ch);
    }
}
