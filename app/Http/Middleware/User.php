<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class User
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
        $user_id=$request->get('user_id');
        $key=":view:".$user_id;

        $field=$_SERVER["REQUEST_URI"];
        if(strpos($field,'?')){
            $field1=strpos($field,'?');
            $field2=substr($field,0,$field1);
            Redis::hincrby($key,$field2,1);
        }
        return $next($request);
    }
}
