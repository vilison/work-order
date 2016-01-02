<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $fillable = ['operator', 'action'];

    public function scopeRecent($query){
        return $query->orderBy('created_at','desc');
    }

    public function scopeBetween($query,$day1,$day2){
        if(!empty($day1) && !empty($day2))
            return $query->whereBetween('created_at', array($day1, $day2));
        return $query;
    }

    public function scopeOperator($query,$operator){
        if(!empty($operator))
            return $query->where('operator','=',$operator);
        return $query;
    }

    public function scopeKey($query,$key){
        if(!empty($key))
            return $query->where('action','like','%'.$key.'%');
        return $query;
    }

    public function scopeDayBefore($query,$day){
        if(!empty($day))
            return $query->where('created_at','<=',$day);
        return $query;
    }
}
