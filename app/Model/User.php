<?php

namespace App\Model;
use App\GeneralModel;

class User extends GeneralModel
{
    protected  $table = 'users';
    protected $fillable = ['name','email','email_verified_at','password','remember_token','created_at',
                    'updated_at','profile_picture','type','user_device','phone','ca_no','id_card',
                    'lang','notification','cuskey','pubkey','seckey','merchant','hash_key','hash_pass'
        ];
    // Close timestamp
    public     $timestamps = true;
    // protected  $rules = array();
    // protected  $messages = array();


    
}