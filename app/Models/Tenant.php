<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    //
    protected $fillable = ['name', 'wechat', 'alipay', 'site'];
    public function user() {
        return $this->hasOne(User::class);
    }
}
