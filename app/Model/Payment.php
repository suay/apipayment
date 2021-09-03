<?php

namespace App\Model;
use App\GeneralModel;

class Payment extends GeneralModel
{
    protected  $table = 'payment';
    protected $fillable = ['id','userid','happy_inv','reference_no','typepay','amount','cardname','cardnum',
                    'detail','gbreference_no','customer_name','customer_email','merchantdefined1','merchantdefined2','merchantdefined3',
                    'merchantdefined4','merchantdefined5','currencycode','payment_status','created_at'
                    ,'updated_at','runing_number'
        ];
    // Close timestamp
    public     $timestamps = true;
    // protected  $rules = array();
    // protected  $messages = array();


    
}