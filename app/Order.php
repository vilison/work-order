<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'current',
        'location_id',
        'time_log',
        'data_content',
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
        'RepairInfo',
        'Engineer',
        'RepairCreateTime',
        'RespTime',
        'ArrivalTime',
        'RepairformSts',
        'MaintianComTel',
        'GivenArrivalTime',
        'Mobile',
        'ebs_id',
        'ebs_content',
        'flag1',
        'flag2',
        'flag3',
        'flag4',
        'flag5'
    ];

    public function scopeOrder($query,$name,$sort){
        if(empty($name))
            $name = 'RepairCreateTime';
        if(empty($sort))
            $sort = 'desc';
        return $query->orderBy($name,$sort);
    }
}
