<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'flag5',
        'api_id'
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

    public function scopeBetween($query,$day1,$day2){
        if(!empty($day1) && !empty($day2))
            return $query->whereBetween('RepairCreateTime', array($day1, $day2));
        return $query;
    }

    public function scopeProvince($query,$province){
        if(!empty($province) && $province != '0') {
            $nhservers = Nhserver::province($province);
            if($nhservers){
                $ids = array();
                foreach($nhservers as $nhserver){
                    $ids[] = $nhserver->id;
                }
                return $query->whereIn('location_id',$ids);
            }
        }
        return $query;
    }

    /**
     * @param $query
     * @param $sn
     * @return mixed
     */
    public function scopeSn($query,$sn){
        if(!empty($identifier)){
            return $query->where('sn','=',$sn);
        }
        return $query;
    }

    /**
     * @param $query
     * @param $ccc
     * @return mixed
     */
    public function scopeCcc($query,$ccc){
        if(!empty($ccc)){
            return $query->where('ccc','=',$ccc);
        }
        return $query;
    }

    public function scopeWformid($query,$wformid){
        if(!empty($wformid)){
            return $query->where('WFormId','=',$wformid);
        }
        return $query;
    }

    public function scopeEngineer($query,$engineer){
        if(!empty($engineer)){
            $engineers = Engineer::name($engineer);
            if($engineers){
                $ids = array();
                foreach($engineers as $engineer){
                    $ids[] = $engineer->id;
                }
                $eds = EngineerDevice::eids($ids);
                if($eds){
                    $eids = array();
                    foreach($eds as $ed){
                        $eids[] = $ed->identifier;
                    }
                    return $query->whereIn('Identifier',$eids);
                }
            }

        }
        return $query;
    }

    public function scopeTicketStatu($query,$ticketStatu){
        if(!empty($ticketStatu) && $ticketStatu != '0'){
            return $query->where('RepairformSts','=',$ticketStatu);
        }
        return $query;
    }

    public function scopeTimeoutMode($query,$timeoutMode,$warn_timeout){
        if(!empty($timeoutMode) && $timeoutMode != 0){
            if($timeoutMode == 1){
                return $query->whereRaw('TIMESTAMPDIFF(MINUTE,RepairCreateTime,now()) > '.$warn_timeout);
            }else if($timeoutMode == 2){
                return $query->whereRaw('TIMESTAMPDIFF(MINUTE,RespTime,now()) > '.$warn_timeout);
            }else if($timeoutMode == 3){
                return $query->whereRaw('TIMESTAMPDIFF(MINUTE,ArrivalTime,now()) > '.$warn_timeout);
            }
        }
        return $query;
    }

}
