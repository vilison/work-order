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

    public function scopeEids($query,$eids){
        if(!empty($eids)){
            return $query->whereIn('engineer_id',$eids);
        }
        return $query;
    }
}
