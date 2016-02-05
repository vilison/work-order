<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineerDevice extends Model
{
    //
    protected $fillable = [
        'location_name',
        'identifier',
        'device_sn',
        'engineer_name',
        'workcardid',
        'mobile'
    ];

    public function scopeSn($query,$device_sn){
        if(!empty($device_sn)){
            return $query->where('device_sn','like','%'.$device_sn.'%');
        }
        return $query;
    }

    public function scopeNameMobile($query,$name,$mobile){
        if(!empty($name) && !empty($mobile))
            return $query->where('engineer_name','=',$name)->where('mobile','=',$mobile);
        return $query;
    }

//    public function scopeEids($query,$eids){
//        if(!empty($eids)){
//            return $query->whereIn('engineer_id',$eids);
//        }
//        return $query;
//    }
}
