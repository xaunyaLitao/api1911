<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    public $table='p_users';  //声明使用的表
    protected $primaryKey = 'user_id';  //声明表的主键
}
