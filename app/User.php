<?php

namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class User extends Authenticatable implements JWTSubject
    {
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected  $table = 'users';
        protected $fillable = [
                    'name','email','email_verified_at','password','remember_token','created_at',
                    'updated_at','profile_picture','type','user_device','phone','ca_no','id_card',
                    'lang','notification','cuskey','pubkey','seckey','merchant','hash_key','hash_pass'

        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'rememberToken',
        ];

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
    }
