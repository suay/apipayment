<?php

namespace App\Http\Controllers\payment;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;
use Redirect;

use Carbon\Carbon;
// use app\Model\Respayment;
use Illuminate\Support\Facades\Log;

class PaymentsController extends Controller
{
  

    public function payform(Request $request)
    {
       // if( $request->all() ) {
       //      $respayment = Respayment::create([
       //          'respone_json' => json_encode($request->all()),
       //          'created_at' => date('Y-m-d H:i:s')
       //      ]);
       //      //$request->get('resultCode')
       //      //$response="00";
       //      if($request->get('resultCode')=='00'){
       //          $status = 1;
       //      }else{
       //          $status = 0;
       //      }   

         // return view('pay.response')->with(compact('status'));

        // }
        $status = 0;
        return view('pay.form');
    }

    public function index()
    {
        return view('payment');
    }

    /**
     * Show the application view error page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function responsepage ()
    {
        $data = array(
            'status' => 'successful',
            'message' => 'Thank you for payment Successfully completed.'
        );
        return view('/response',compact("data"));

    }

    public function responsepage2c2p(Request $request)
    {

      $data = array(
            'status' => 'successful',
            'message' => 'Thank you for payment Successfully completed.'
        );
        return view('/response',compact("data"));
    }
}