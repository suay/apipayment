<?php

namespace App\Model;
use App\GeneralModel;

class Reqpayment extends GeneralModel
{
    protected  $table = 'req_payment';
    protected $fillable = ['idpay','request_json','created_at','updated_at'
        ];
    // Close timestamp
    public     $timestamps = true;
    // protected  $rules = array();
    // protected  $messages = array();


    
}