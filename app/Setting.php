<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'supplier_number',
        'mail_server',
        'mail_server_port',
        'mail_account',
        'mail_password',
        'crm_server',
        'crm_server_port',
        'crm_account',
        'crm_password',
        'timeout',
        'refresh_interval'
    ];
}
