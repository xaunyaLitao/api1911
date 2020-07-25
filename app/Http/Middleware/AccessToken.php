<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use App\Model\TokenModel;
class AccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request ->get('token');
        if(empty($token)){
            $response = [
                'erron' => '50009',
                'msg' => '未授权'
            ];
            print_r($response);

        }
        //已授权  判断token
        $tokens = TokenModel::where('token', $token)->first();
        if (!$tokens) {
//                token输入正确
//                判断时间是否过期
//                if ($tokens->expires_in - time() < 7200) {
//                    //未过期 正常获取信息
//                    $reg = Reg::where('user_id', $tokens->user_id)->first();
//                    $response = [
//                        'erron' => 0,
//                        'msg' => 'ok',
//                        'user_name' => $reg->user_name,
//                        'user_email' => $reg->user_email
//                    ];
//                    return $response;
//                } else {
//                    //已过期给出提示
//                    $response = [
//                        'erron' => '50010',
//                        'msg' => 'token已经过期请重新获取'
//                    ];
//                    return $response;
//                }
//            } else {
            //token不正确
            $response = [
                'erron' => '50009',
                'msg' => 'token输入错误'
            ];
            print_r($response);
        }
        $request->attributes->add(['user_id'=>$tokens->user_id]);
        return $next($request);
    }
}
