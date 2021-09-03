<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;


class UserController extends Controller
{

    public function getUser()
        {

                $user = User::find(auth()->user()->id);
                
                return response()->json(['result'=>array('success'=>true),'info'=>$user]);
        }
      
    
}

 