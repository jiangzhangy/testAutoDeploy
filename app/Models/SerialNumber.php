<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumber extends Model
{
    use HasFactory;
    // 一个序列号拥有一个软件名
    public function soft()
    {
        return $this->belongsTo('App\Models\Soft');
    }
}
