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

    public function scopeName($query,$name){
        if(!empty($name)){
            return $query->where('name','=',$name);
        }
        return $query;
    }
}
