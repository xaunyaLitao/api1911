<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\TokenModel;
use App\Model\UserModel;
use Illuminate\Support\Str;
class LoginController extends Controller
{
    public function reg()
    {
        return view('index/reg');
    }

     // 用户注册逻辑
     public function regdo(Request $request)
     {
         // 接收值
         $uname=$request->input('uname');
         $upwd=$request->input("upwd");
         $upwds=$request->input("upwds");
         $user_email=$request->input("user_email");
        
         // 验证密码长度
         $str= strlen($upwd);
         if($str<6){
             die('密码长度必须是6位以上');
         }
 
         // 验证密码和确认密码
         if($upwds !=$upwd){
             die("密码和确认密码不一致,请重新输入");
         }
 
         // 检测用户是否存在
         $res=UserModel::where(['uname'=>$uname])->first();
         if($res){
             die("用户已存在");
         }
 
         //  生成密码
         $upwd=password_hash($upwds,PASSWORD_BCRYPT);
 
         // 验证通过 添加用户
          $data= [
             'uname'=>$uname,
             'upwd'=>$upwd,
             'user_email'=>$user_email,
             'reg_time'=>time()
          ];
          
          $user=UserModel::insertGetId($data);
          if($user==true){
              $resposen=[
                'erron'=>0,
                'msg'=>'注册成功'
              ];
              return $resposen;
          }else{
            $resposen=[
                'erron'=>40001,
                'msg'=>'注册失败'
              ];
              return $resposen;
          }
     }



    //  用户登录
     public function login(Request $request)
     {
         $uname=$request->post('uname');
         $upwd=$request->post('upwd');
        
        $user=UserModel::where(['uname'=>$uname])->first();

        if($user){
              // 生成token接口在把token存入数据库
              $token=Str::random(32);
            
              $data=[
                  'token'=>$token,
                  'user_id'=>$user->user_id,
                  'expires_in'=>time()+7200
              ];
  
              $tid=TokenModel::insertGetId($data);


              // 验证密码
        $res=password_verify($upwd,$user->upwd);
        if($res){
            $resposen=[
                'erron'=>0,
                'msg'=>'ok',
                'token'=>$token
            ];
            return $resposen;
        }else{
            $resposen=[
                'erron'=>50001,
                'msg'=>'用户名和密码错误,请重新登录'
            ];
            return $resposen;
        }
          
        }else{
            $resposen=[
                'erron'=>50001,
                'msg'=>'用户名和密码错误,请重新登录'
            ];
            return $resposen;
        }
     }


     public function center(Request $request)
     {
        $token=$request->get('token');
        if(empty($token)){
            $resposen=[
                'erron'=>50009,
                'msg'=>'未授权'
            ];
            return $resposen;
        }else{
            //已授权 判断token是否正确
            $tokens=TokenModel::where(['token'=>$token])->first();
            if($tokens){
                // token输入正确
                // 判断时间是否过期
                if($tokens->expires_in- time()<7200){
                    // 未过期 正常获取信息
                    $reg=UserModel::where('user_id',$tokens->user_id)->first();
                    $resposen=[
                        'erron'=>0,
                        'msg'=>'ok',
                        'uname'=>$reg->uname,
                        'user_email'=>$reg->user_email
                    ];
                    return $resposen;
                }else{
                    // 已过期
                    $resposen=[
                        'erron'=>500010,
                        'msg'=>'token已过期请重新获取'
                    ];
                    return $resposen;
                }
            }else{
                // token不正确
                $resposen=[
                    'erron'=>50009,
                    'msg'=>'token输入错误'
                ];
                return $resposen;
            }
        }
     }
}
