<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
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

    public $ticketStatus = array(
        1=>'保修',
        2=>'已反馈',
        3=>'到场',
        4=>'关闭'
    );

    /**获取工单状态
     * @return mixed
     */
    public function getTicketStatu(){
        return $this->ticketStatus[$this->RepairformSts];
    }

    public function getCheck($tids){
        if(in_array($this->id,$tids))
            return true;
        return false;
    }

    public function getResp($warn_timeout,$msg = "√"){
        if($this->RepairformSts == 1){
            $d1 = time();
            $d2 = strtotime($this->RepairCreateTime);
            $min = ($d1 - $d2)/60;
            if($min > $warn_timeout)
                return $msg;
        }
    }

    public function getArrival($warn_timeout,$msg = "√"){
        if($this->RepairformSts == 2){
            $d1 = time();
            $d2 = strtotime($this->RespTime);
            $min = ($d1 - $d2)/60;
            if($min > $warn_timeout)
                return $msg;
        }
    }

    public function getRepair($warn_timeout,$msg = "√"){
        if($this->RepairformSts == 3){
            $d1 = time();
            $d2 = strtotime($this->ArrivalTime);
            $min = ($d1 - $d2)/60;
            if($min > $warn_timeout)
                return $msg;
        }
    }

    public function getLocation(){
        $nhserver = Nhserver::find($this->location_id);
        if($nhserver){
            return $nhserver->province;
        }
        return '';
    }

    public function scopeOrder($query,$name,$sort){
        if(empty($name))
            $name = 'RepairCreateTime';
        if(empty($sort))
            $sort = 'desc';
        return $query->orderBy($name,$sort);
    }

    public function scopeCurrent($query){
        return $query->where('current','=',1);
    }
}
