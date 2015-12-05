<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nhserver extends Model
{
    //
    protected $fillable = [
        'host',
        'port',
        'province'
    ];
}
