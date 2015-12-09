<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineerDevice extends Model
{
    //
    protected $fillable = [
        'identifier',
        'device_sn',
        'engineer_id'
    ];
}
