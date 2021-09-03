<?php

namespace App\Model;
use App\GeneralModel;

class Respayment extends GeneralModel
{
    protected  $table = 'resp_payment';
    protected $fillable = ['idpay','result_code','respone_json','created_at','updated_at'
        ];
    // Close timestamp
    public     $timestamps = true;
    // protected  $rules = array();
    // protected  $messages = array();


    
}