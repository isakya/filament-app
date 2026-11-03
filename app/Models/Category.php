<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ // 这是 批量赋值白名单，意思是：只有 name 和 slug 这两个字段允许通过批量赋值的方式写入数据库。
        "name",
        "slug"
    ];
}
