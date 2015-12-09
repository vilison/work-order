<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    //
    protected $fillable = [
        'name',
        'workcardid',
        'mobile'
    ];
}
