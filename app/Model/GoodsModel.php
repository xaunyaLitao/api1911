<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    public $table='p_goods';  //声明使用的表
    protected $primaryKey = 'goods_id';  //声明表的主键
}
