<?php

namespace App\Model;
use App\GeneralModel;

class Errorpayment extends GeneralModel
{
    protected  $table = 'error_payment';
    protected $fillable = ['reference_no','result_code','message_error','respone_json','created_at','updated_at'
        ];
    // Close timestamp
    public     $timestamps = true;
    // protected  $rules = array();
    // protected  $messages = array();


    
}