<?php

namespace App\Model;
use App\GeneralModel;

class Reqtoken extends GeneralModel
{
    protected  $table = 'req_token';
    protected $fillable = ['userid','req_json','resp_json','created_at','updated_at'
        ];
    // Close timestamp
    public     $timestamps = true;
    // protected  $rules = array();
    // protected  $messages = array();


    
}