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

    public function scopeProvince($query,$province){
        if(!empty($province)) {
            return $query->where('province','=',$province);
        }

    }
}
