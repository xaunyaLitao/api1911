<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\UsersModel;
use App\Model\GoodsModel;
use Illuminate\Support\Str;
class TestController extends Controller
{
    public function test1()
    {
        $url = "http://api.1911.com/test1";
        $response = file_get_contents($url);
        echo $response;
    }

    public function info()
    {
        echo 123;
    }


    public function hash()
    {
        $data = [
            'name' => 'lisi',
            'email' => '12345@qq.com',
            'age' => 18
        ];
        $key = "zhangxuetao";
        Redis::hmset($key, $data);
    }

    public function hash1()
    {
        $key = "zhangxuetao";
        $data = Redis::hgetall($key);
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }

    public function test2()
    {
        $key = "storge";
        Redis::lpop($key);
        $len = Redis::llen($key);
        if ($len <= 0) {
            $data = [
                'msg' => '库存不足'
            ];
            return $data;
        } else {
            $data = [
                'msg' => 'ok'
            ];
            return $data;
        }
    }

    public function goods(Request $request)
    {
        $goods_id = $request->get('id');

        $key = 'h:goods_info:' . $goods_id;

//    先判断缓存
        $goods_info = Redis::hgetAll($key);
        if (empty($goods_info)) {
            $g = GoodsModel::select('goods_id', 'goods_sn', 'cat_id', 'goods_name')->find($goods_id);
//        dd($g);die;
            // 缓存到redis中
            $goods_info = $g->toArray();
            Redis::hMset($key, $goods_info);
            echo "无缓存";
            echo '<pre>';
            print_r($goods_info);
            echo '</pre>';
        } else {
            echo "缓存";
            echo '<pre>';
            print_r($goods_info);
            echo '</pre>';
        }

//    增加访问次数
        Redis::hincrby($key, 'view_count', 1);
    }

    public function infos()
    {
        echo 'info';
    }


//        对称加密 get
    public function encr1()
    {
        $data = 'hello world';  //加密数据
        $method = 'AES-256-CBC';   //加密算法
        $key = '1911api';  //加密的key
        $iv = 'aaabbbcc/0/0/0//';
        $enc_data = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
        echo '加密的数据：' . $enc_data;
        echo '<br>';

        $bas = base64_encode($enc_data);
        $url = "http://api.1911.com/test/dec";
    }


//    非对称加密
    public function enc2()
    {
        $data = "l'm you 法则";
        $content = file_get_contents(storage_path('keys/pub.key'));
//        dd($content);
        $puy_key = openssl_get_publickey($content);
        openssl_public_encrypt($data, $enc_data, $puy_key);
        $b64 = base64_encode($enc_data);
        $url = "http://api.1911.com/test/dec2";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => [
                'data' => $b64
            ]
        ]);
        echo $response->getBody();
        $la = $response->getBody();
        $api_data = base64_decode($la);

//        获取www私钥
        $www_key = file_get_contents(storage_path('keys/priv.key'));
        $www_priv = openssl_get_privatekey($www_key);
        openssl_private_decrypt($api_data, $den_data, $www_priv);
        echo "解密的数据:" . $den_data;

    }

//    签名


    public function sign2()
    {
        $data = "啦啦啦";  //加密的数据
        $priv_key = file_get_contents(storage_path('keys/priv.key'));  //获取私钥加密
        $priv_content = openssl_get_privatekey($priv_key);  //解析私钥
        openssl_sign($data, $dec_data, $priv_content);   //签名
//        dd($dec_data);
        $bas4 = base64_encode($dec_data);  //对加完密的数据进行编码
        $bas4 = urlencode($bas4);  //编码字符串
        $data = base64_encode($data);  //对加密的数据data进行编码
        $data = urlencode($data);  //编码字符串
        $url = "http://api.1911.com/test/sign2?data=" . $data . "&sign=" . $bas4;  //url  get
        $response = file_get_contents($url);  //读取成字符串
        echo $response;
    }


    public function sign3()
    {
        $data = 'hello 傻逼';  //加密数据
        $method = 'AES-256-CBC';   //加密算法
        $key = '1911api';  //加密的key
        $iv = 'aaabbbcc/0/0/0//';
        $enc_data=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "加密的数据:".$enc_data;
    }

    public function header1()
    {
        $uid="123";
        $token=Str::random(16);
        $url="http://api.1911.com/test/header1";
        $headers=[
                'uid:'.$uid,
                'token:'.$token,
        ];
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_exec($ch);
        curl_close($ch);
    }


//    支付页面
    public function testPay()
    {
        return view('index/goods');
    }

//    跳转支付宝支付
    public function pay(Request $request)
    {
        $oid=$request->get('oid');
//        echo "订单号:".$oid;

        //根据订单查询到订单信息  订单号  订单金额

        //调用 支付宝支付接口

        // 1 请求参数
        $param2 = [
            'out_trade_no'      => time().mt_rand(11111,99999),
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'      => 10000,
            'subject'           => '1911-测试订单-'.Str::random(16),
        ];

        //  公共参数
        $param1 = [
            'app_id'        => '2016101900720833',
            'method'        => 'alipay.trade.page.pay',
            'return_url'    => 'http://1911lxt.comcto.com/alipay/return',   //同步通知地址
            'charset'       => 'utf-8',
            'sign_type'     => 'RSA2',
            'timestamp'     => date('Y-m-d H:i:s'),
            'version'       => '1.0',
            'notify_url'    => 'http://1911lxt.comcto.com/alipay/notify',   // 异步通知
            'biz_content'   => json_encode($param2),
        ];

        // 计算签名
        ksort($param1);

        $str = "";
        foreach($param1 as $k=>$v)
        {
            $str.= $k . '=' . $v . '&';
        }

        $str = rtrim($str,'&');     // 拼接待签名的字符串

        $sign = $this->sign($str);
        echo $sign;echo '<hr>';

        //沙箱测试地址
        $url = 'https://openapi.alipaydev.com/gateway.do?'.$str.'&sign='.urlencode($sign);
        return redirect($url);
        //echo $url;
    }

    public function sign($data){
        $priKey = file_get_contents(storage_path('keys/ali_priv.key'));
        $res = openssl_get_privatekey($priKey);
        var_dump($res);echo '<hr>';

        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }
}

