<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    protected $fillable = ['title', 'description', 'image'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getImageUrlAttribute()
    {
        // 如果 image 字段本身就已经是完整的 url 就直接返回
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
            return $this->attributes['image'];
        }
        return \Storage::disk('public')->url($this->attributes['image']);
    }
    public $cache_key = 'product_categories';
    protected $cache_expire_in_minutes = 1440;

    public static function getAllCached()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        return ProductCategory::all();
        /*return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function(){
            return $this->all();
        });*/
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
