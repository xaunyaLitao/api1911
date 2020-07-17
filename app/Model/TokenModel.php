<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    public $table='p_token';  //声明使用的表
    protected $primaryKey = 'id';  //声明表的主键
}
