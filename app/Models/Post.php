<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        "title",
        "slug",
        "category_id",
        "color",
        "image",
        "body",
        "tags",
        "published",
        "published_at",
    ];

    // Laravel 模型中的 属性类型转换，用来自动把数据库里的值转成 PHP 常用类型，取出来和存回去时都会自动处理
    protected $casts = [
        "tags" => "array",
        "publishe" => "boolean",
        "publishe_at" => "ate"
    ];

    // Laravel 模型中定义的 一对多反向关联（Belongs To），意思是：一篇文章属于一个分类。
    public function category() {
        return $this->belongsTo(Category::class);
    }

}
