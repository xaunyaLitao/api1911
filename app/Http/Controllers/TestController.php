<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test1()
    {
        $url="http://api.1911.com/test1";
        $response=file_get_contents($url);
        echo $response;
    }

    public function info()
    {
        echo 123;
    }
}
