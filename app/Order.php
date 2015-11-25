<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $primaryKey = 'WFormId';
    //
    protected $fillable = [
        'WFormId',
        'Identifier',
        'WFormSetTime',
        'ReplyDue',
        'IsChecked',
        'ArriveDue',
        'WFormContent',
        'OrgName',
        'InstallAddress',
        'ModelId',
        'BrandId',
        'DevManager',
        'DevManagerTel',
        'RepairInfo',
        'Engineer',
        'RepairCreateTime',
        'RespTime',
        'ArrivalTime',
        'RepairformSts',
        'MaintianComTel',
        'GivenArrivalTime',
        'Mobile'
    ];

    public function scopeOrder($query,$name,$sort){
        if(empty($name))
            $name = 'RepairCreateTime';
        if(empty($sort))
            $sort = 'desc';
        return $query->orderBy($name,$sort);
    }
}
