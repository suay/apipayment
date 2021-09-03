<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;
use Carbon\Carbon;
// use App\User;
// use App\Model\Reqtoken;
// use App\Model\Payment;
// use App\Model\Reqpayment;
// use App\Model\Errorpayment;
// use App\Model\Respayment;

use Illuminate\Support\Facades\Log;
use Mail;

class PaymentController extends Controller
{
    public function cksendmail(Request $request)
    {
        $all = $request->all();
        if(empty( $all['email']) ){
          return response()->json(['error'=>'11','message'=>'Request Customer Name.']);
          exit;
        }

        $to_name = "test email";
        $to_email = $all['email'];
        $data = array('name'=> "testmail",
                           "servicelink" => "https://".$to_name.".netkadev.com",
                            "agent" => "1",
                            "package" => "test package",
                            "expire" => "2021-07-29",
                            "genpass" => "-",
                            "start"=> "2021-07-29",
                            "licenseno" => "No111111");
        Mail::send(array('html' => 'mail'), $data, function($message) use ($to_name, $to_email) {
              $message->to($to_email, $to_name)
                      ->subject('Your NetkaQuartz Service Desk X on Cloud is ready to use.');
              $message->from('itsm@netkasystem.com','Your NSDX SaaS Ready');
        });
    }

    //============================ start payment 2c2p =======================================================//

    public function charge2c2p(Request $request)
    {
      var_dump($request->all());
      exit;
           //check is empty
      if ( empty($request->input('username')) ){
        return response()->json(['error'=>'11','message'=>'Request Customer Name.']);
        exit;
      }
        
      if (  empty( $request->input('packagename') ) ){
        return response()->json(['error'=>'12','message'=>'Request Package Name.']);
        exit;
      }
        
      if (  empty( $request->input('agent') ) ){
        return response()->json(['error'=>'13','message'=>'Request Agent Count.']);
        exit;
      }
        
      if ( empty( $request->input('payper') ) ){
        return response()->json(['error'=>'14','message'=>'Request Payper.']);
        exit;
      }
        
      if ( empty( $request->input('order_id') ) ){
        return response()->json(['error'=>'15','message'=>'Request OrderID.']);
        exit;
      }
        
      if ( empty( $request->input('amount') ) ){
        return response()->json(['error'=>'16','message'=>'Request Amount.']);
        exit; 
      }
        
      if ( empty( $request->input('currency') ) ){
        return response()->json(['error'=>'16','message'=>'Request Currency.']);
        exit;
      }

        $username = $request->input('username');
        $packagename = $request->input('packagename');
        $agent = $request->input('agent');
        $pay_per = $request->input('payper');
        //check conditional
        switch($pay_per){
          case "month":
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d',strtotime('+1 month', strtotime($startdate)));
          break;
          case "year":
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d',strtotime('+1 year', strtotime($startdate)));
          break;
          default:
            $startdate = "";
            $enddate = "";
          break;
        }
        
        $packingdata = $username.':'.$packagename.':'.$agent.':'.$pay_per.':'.$startdate.':'.$enddate;
        $min = date('his');
    	//$urlpay = env('URL2C2P');
    	$secret_key = 'D97EE54180CF124D12961DB49A21BBF4D6C1AE3A8545CF062DC0517EDD3A7F04';//env('SECRET_KEY2C2P');
      //production
      //$secret_key = 'DF6B6D630191EBAB3BB0DF6E2A35DCB11B8F7D7468E815E676570D86FE682833';

    	$version = '8.5'; //
    	$merchant_id = '764764000004784';//env('MERCHANT_ID2C2P'); //
    	$payment_description = $request->input('payment_description'); //
    	$order_id = $request->input('order_id').$min; //
    	$user_defined_1 = $request->input('user_defined_1'); //
    	$user_defined_2 = $packingdata; //
    	$user_defined_3 = $request->input('user_defined_3'); //
    	$user_defined_4 = $request->input('user_defined_4'); //
    	$user_defined_5 = $request->input('user_defined_5'); //
    	$amount_noneset = $request->input('amount'); //
    	$currency = $request->input('currency');
    	$promotion = $request->input('promotion'); //
    	$customer_email =$request->input('customer_email'); //
    	//$result_url_1 = 'http://localhost:8000/happypay/public/responsepage2c2p'; //responsepage2c2p
    	//$result_url_2 = 'http://localhost:8000/happypay/public/api/responseback'; //
    	$payment_option = 'CC'; //
    	$ipp_interest_type = ''; //
    	$payment_expiry = ''; //
    	$default_lang = ''; //
    	$enable_store_card = 'Y'; //
    	$stored_card_unique_id = ''; //
    	$request_3ds = 'Y'; //
    	$recurring = ''; //
    	$order_prefix = ''; //
    	$recurring_amount = ''; //
    	$allow_accumulate = ''; //
    	$max_accumulate_amount = ''; //
    	$recurring_interval = ''; //
    	$recurring_count = ''; //
    	$charge_next_date = ''; //
    	$charge_on_date = ''; //
    	$statement_descriptor = ''; //
    	$use_storedcard_only = ''; //
    	$tokenize_without_authorization = ''; //
    	$product_code = ''; //
    	$ipp_period_filter = ''; //
    	$sub_merchant_list = ''; //
    	$qr_type = ''; //
    	$custom_route_id = ''; //
    	$airline_transaction = ''; //
    	$airline_passenger_list = ''; //

    	$amount = sprintf("%012d",str_replace('.','', number_format($amount_noneset,2, '.', '') ));


    	$params = $version . $merchant_id . $payment_description . $order_id .
				$currency . $amount . $customer_email .
				$promotion . $user_defined_1 . $user_defined_2 .
				$user_defined_3 . $user_defined_4 . $user_defined_5 .
                $enable_store_card .
				$stored_card_unique_id . $request_3ds . $recurring .
				$order_prefix . $recurring_amount . $allow_accumulate .
				$max_accumulate_amount . $recurring_interval .
				$recurring_count . $charge_next_date. $charge_on_date .
				$payment_option . $ipp_interest_type . $payment_expiry .
				$default_lang . $statement_descriptor . $use_storedcard_only .
				$tokenize_without_authorization . $product_code . $ipp_period_filter .
				$sub_merchant_list . $qr_type . $custom_route_id . $airline_transaction .
				$airline_passenger_list;//$result_url_1 . $result_url_2 .
    	$hash_value = hash_hmac('sha256',$params, $secret_key,false);

    	$datasend = 'version='.$version .'&merchant_id='. $merchant_id .'&payment_description='. $payment_description .'&order_id='. $order_id .'&currency='. $currency .'&amount='. $amount .'&customer_email='. $customer_email .'&promotion='.$promotion .'&user_defined_1='. $user_defined_1 .'&user_defined_2='. $user_defined_2 .'&user_defined_3='.$user_defined_3 .'&user_defined_4'. $user_defined_4 .'&user_defined_5'. $user_defined_5 .'&enable_store_card='. $enable_store_card .'&stored_card_unique_id='.$stored_card_unique_id .'&request_3ds='. $request_3ds .'&recurring='. $recurring .'&order_prefix='.$order_prefix .'&recurring_amount='. $recurring_amount .'&allow_accumulate='. $allow_accumulate .'&max_accumulate_amount='.$max_accumulate_amount .'&recurring_interval='. $recurring_interval .'&recurring_count='.$recurring_count .'&charge_next_date='. $charge_next_date .'&charge_on_date='. $charge_on_date .'&payment_option='.$payment_option .'&ipp_interest_type='. $ipp_interest_type .'&payment_expiry='. $payment_expiry .'&default_lang='.$default_lang .'&statement_descriptor='. $statement_descriptor .'&use_storedcard_only='. $use_storedcard_only .'&tokenize_without_authorization='.$tokenize_without_authorization .'&product_code='. $product_code .'&ipp_period_filter='. $ipp_period_filter .'&sub_merchant_list='.$sub_merchant_list .'&qr_type='. $qr_type .'&custom_route_id='. $custom_route_id .'&airline_transaction='. $airline_transaction .'&airline_passenger_list='.$airline_passenger_list .'&hash_value='.$hash_value; //'&result_url_1='.$result_url_1 .'&result_url_2='. $result_url_2 .

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://demo2.2c2p.com/2C2PFrontEnd/RedirectV3/payment',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 60,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $datasend,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded'
		  ),
		));

		$response = curl_exec($curl);

		$redirectURL = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL );

		curl_close($curl);
		// echo $response;
		return redirect($redirectURL);

    	

    	
    }


    // response 2c2p backend 
    public function responseback(Request $request)
    {
    	$all = $request->all();
    	//Log::channel('eventy')->info('info1',['data' => $all]);
      Log::channel('eventy')->info('info-recurring',['data' => $all]);
      // exit;
      $list = explode(':',$all['user_defined_2']); 
      $typee = $all['user_defined_1'];//type recurring payment plan
      $check_is_recurring = $all['invoice_no'];//$all['recurring_unique_id']; // if null = first payment, if not null  = recurring 1,2,3
      $today = date("Y-m-d");
      $date1 = str_replace('-', '/', $today);
      $region = strtoupper( trim(@$list[5]) );
      $country = strtoupper( trim(@$list[6]) );
      $listdate = explode("-",$today);
      $listmonth = str_pad($listdate[1], 3, '0', STR_PAD_LEFT);
      $listdate1 = str_pad($listdate[2], 3, '0', STR_PAD_LEFT);
      $licenseno = 'NSDXSaaS'.$listdate1.$listmonth.$listdate[0];
      //check free convert to pay not gen newpassword
      if( $all['user_defined_4'] == "convert"){
        $newpassword = '';
      }else{
        $newpassword = $this->GenerateStrongPassword(); //16 digit
      }
      // timezone
      $timezones = $this->ckregion( $region, $country );
        if( is_null($timezones) ){
           $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $list[0] .' -n '. $list[2] . ' -p '. $list[1] . ' -t ' . $list[3] .' -e ' .$list[4].' -u '.$newpassword.' -rp '.$typee;
        }else{
           $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $list[0] .' -n '. $list[2] . ' -p '. $list[1] . ' -t ' . $list[3] .' -e ' .$list[4].' -u '.$newpassword.' -tz '.$timezones.' -rp '.$typee;
        }
        //set exprice 
        switch ($list[3]){
            case "DEMO"://free 30 day
                $nextday = $typee."days";
                $startformat = date('d F,Y',strtotime($date1));
                $expire = date('Y-m-d',strtotime($date1 . $nextday));
                $expireformat = date('d F,Y',strtotime($date1 . $nextday));
            break;
            default:// charge 1 year
                // $today = date("Y-m-d");
                // $date1 = str_replace('-', '/', $today);
                $startformat = date('d F,Y',strtotime($date1));
                $nextday = $typee."days";
                $expire = date('Y-m-d',strtotime($date1 . $nextday));
                $expireformat = date('d F,Y',strtotime($date1 . $nextday));
            break;
        }

        //check plan
        switch ($list[1]) {
          case 'S':
             $planpackage = "Growth";
            break;
          case 'M':
            $planpackage = "Pro";
            break;
          case 'L':
            $planpackage = "Enterprise";
            break;
          default:
            $planpackage = "Starter";
            break;
        }

        if($all['channel_response_code']=="00" && !empty($check_is_recurring)  ){

          //log payment first edit 01-06-2021
          Log::channel('firstpayment')->info('info-firstpay',['data' => $all]);
          //update edit add save log recurring 
          $datapost = json_encode( array( 'type_pay'=> 'recurring',
                        'old_order' => $all['order_id'],
                        'subscription_order' => $all['order_id'],
                        'cus_email' => $list[4],
                        'detail_upgrade' => 'payment recurring',
                        'res_recurring' => $all
                      ) );

           $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://staging2.netkasystem.com/itsmstore/api/upgrade-pay.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$datapost,
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);
          //echo $response;
          //log save recurring
          Log::channel('logfirstpayment')->info('info',['data' => $datapost,'output' => $response]);

          //call RDS /home/ec2-user/aws_provisioning
          //  $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $list[0] .' -n '. $list[2] . ' -p '. $list[1] . ' -t ' . $list[3] .' -e ' .$list[4].' -u '.$newpassword.' -tz '.$timezones;
            /*  -i = instance(customerid)
            -n = จำนวน agent 
            -p = package(starter/S/M/L) 
            -t = demo flag (DEMO/package)
            -e = customer email 
            -tz = timezone (Asia/Bangkok)*/
            putenv('AWS_DEFAULT_REGION=ap-southeast-1');
            putenv('AWS_ACCESS_KEY_ID=AKIAUNHYTT7SA2B3W3KG');
            putenv('AWS_SECRET_ACCESS_KEY=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');
            $output = shell_exec($scripts); 
            echo "<pre>$output</pre>";
            $scriptoutput =  "<pre>$output</pre>";
            //log call script
            Log::channel('callscript')->info('script',['data' => $scripts,'output' => $scriptoutput]);


            $urlckcurl = 'http://'.$list[0].'.netkadev.com/shared/checkempty';//'http://'.$username.'.itsmnetka.com/Login';
            $i=10;
            $k=0;
            $httpcode = "";
            while($k<=$i){
               ini_set('max_execution_time', 300); // prevents 30 seconds from being fatal

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
                curl_setopt($ch, CURLOPT_TIMEOUT, 200); // curl timeout remains at 3 minus
                curl_setopt($ch, CURLOPT_URL, $urlckcurl);
                $data = curl_exec($ch);
                $curl_errno = curl_errno($ch);
                $curl_error = curl_error($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch); 

                if($httpcode<>200){
                    sleep(60);
                    Log::channel('checkhttpstatus')->info('statussleep',[$httpcode]);
                }else{
                    Log::channel('checkhttpstatus')->info('statuspass',[$httpcode]);
                    break;
                }

                $k++;
            }

            Log::channel('checkhttpstatus')->info('status',[$httpcode]);

            if($httpcode=="200"){
                Log::channel('checkhttpstatus')->info('status200',[$httpcode]);

              $to_name = $list[0];
              $to_email = $list[4];
              $data = array('name'=> $list[0],
                           "servicelink" => "https://".$list[0].".netkadev.com",
                            "agent" => $list[2],
                            "package" => $planpackage,
                            "expire" =>$expireformat,
                            "genpass" => $newpassword,
                            "start" => $startformat,
                            "licenseno" => $licenseno);
                   
              Mail::send(array('html' => 'mail'), $data, function($message) use ($to_name, $to_email) {
                  $message->to($to_email, $to_name)
                          ->subject('Your NetkaQuartz Service Desk X on Cloud is ready to use.');
                  $message->from('itsm@netkasystem.com','Your NSDX SaaS Ready');
              });
            }
        }else{
            // for recurring only
            //log เฉพาะ recurring
            Log::channel('recurring')->info('recurring_info',['data' => $all]);
            $recuringorder_id = $all['order_id']; //order id
            $username = $list[0]; //username
            $emailcus = $list[4]; //email customer
            $invoice = $recuringorder_id;//$all['invoice_no']; //invoice number find 
            $flist = substr($recuringorder_id, 0,8);
            $selist = substr($recuringorder_id, 8,-5);
            $thlist = substr($recuringorder_id, -5);
            $order_id = $selist;
            $genpass = '';

            //var_dump($emailcus);exit;
            $datapost = 'invoice_no='.$invoice.'&email='.$emailcus.'&username='.$username.'&order_id='.$order_id;
            //script 
            $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $list[0] .' -n '. $list[2] . ' -p '. $list[1] . ' -t ' . $list[3] .' -e ' .$list[4].' -u '.$genpass.' -tz '.$timezones.' -rp '.$typee;


            /*  -i = instance(customerid)
            -n = จำนวน agent 
            -p = package(starter/S/M/L) 
            -t = demo flag (DEMO/package)
            -e = customer email 
            -tz = timezone (Asia/Bangkok)
            -rp = days for expire*/
            putenv('AWS_DEFAULT_REGION=ap-southeast-1');
            putenv('AWS_ACCESS_KEY_ID=AKIAUNHYTT7SA2B3W3KG');
            putenv('AWS_SECRET_ACCESS_KEY=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');
            $output = shell_exec($scripts); 
            echo "<pre>$output</pre>";
            $scriptoutput =  "<pre>$output</pre>";
            //log call script
            Log::channel('callscriptrecurring')->info('script',['data' => $scripts,'output' => $scriptoutput]);

            //curl call send email invoice
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://staging2.netkasystem.com/itsmstore/api/callinvoice.php',//https://netkasystem.com/itsmstore/api/
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => $datapost,
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            //log response send invoice
            Log::channel('recurring_invoice')->info('recurring_info',['data' => $response]);
            echo $response;
        }
	}



//charge for free
    public function forfree(Request $request){

        $all = $request->all();
        Log::channel('callfree')->info('info1',['data' => $all]);
        $username = $all['username'];
        $agent = $all['agent'];
        $package = $all['package'];
        $type = $all['type'];
        $email = $all['email'];
        $region = strtoupper( trim($all['region']) );
        $country = strtoupper( trim($all['country']) );
        //generate password
        $newpassword =  $this->GenerateStrongPassword(); //16 digit
        // timezone
        $timezones = $this->ckregion( $region, $country );

        // setting is per free trial
        $listisper = explode(" ",$all['isper']); // is per ext. 10 day,week,month,year
        $isperday = $listisper[0];
        $ispertype = $listisper[1];
        $isper = $all['isper'];// convert is day
        //check convert day
        switch($ispertype){
          case "days":
            if($isperday > 1){
                $interval = $isperday ;
            }else{
                $interval = "1";
            }
          break;
          case "weeks":
            if($isperday > 1){
                $interval = $isperday * 7;
            }else{
                $interval = "7";
            }
          break;
          case "months":
            if($isperday > 1){
                $interval = $isperday * 30;
            }else{
                $interval = "30";
            }
          break;
          case "years":
            if($isperday > 1){
                $interval = $isperday * 365;
            }else{
                $interval = "365";
            }
          break;

        }

        if( is_null($timezones) ){
          $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $username .' -n '. $agent . ' -p '. $package . ' -t ' . $type .' -e ' .$email.' -u '.$newpassword.' -rp '.$interval;
        }else{
          $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $username .' -n '. $agent . ' -p '. $package . ' -t ' . $type .' -e ' .$email.' -u '.$newpassword.' -tz '.$timezones.' -rp '.$interval ;
        }
        // var_dump($timezones,$scripts);
        // exit;
        // echo date_default_timezone_get() . ' => ' . date('e') . ' => ' . date('T');
        $today = date("Y-m-d");
        $date1 = str_replace('-', '/', $today);
        $listdate = explode("-",$today);
        $listmonth = str_pad($listdate[1], 3, '0', STR_PAD_LEFT);
        $listdate1 = str_pad($listdate[2], 3, '0', STR_PAD_LEFT);
        $licenseno = 'NSDXSaaS'.$listdate1.$listmonth.$listdate[0];
        //set exprice 
        switch ($type){
            case "DEMO"://free 30 day
                $startformat = date('d F,Y',strtotime($date1));
                $expire = date('Y-m-d',strtotime($date1 . $isper));
                $expireformat = date('d F,Y',strtotime($date1 . $isper));
            break;
            default:// charge 1 year
                // $today = date("Y-m-d");
                // $date1 = str_replace('-', '/', $today);
                $startformat = date('d F,Y',strtotime($date1));
                $expire = 'Expired to: '.date('Y-m-d',strtotime($date1 . "+365 days"));
                $expireformat = date('d F,Y',strtotime($date1 . "+365 days"));
            break;
        }

        //check plan
        switch ($package) {
          case 'S':
             $planpackage = "Growth";
            break;
          case 'M':
            $planpackage = "Pro";
            break;
          case 'L':
            $planpackage = "Enterprise";
            break;
          default:
            $planpackage = "Starter";
            break;
        }

      //  $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $username .' -n '. $agent . ' -p '. $package . ' -t ' . $type .' -e ' .$email.' -u '.$newpassword;

       //  /*  -i = instance(customerid)
       //  -n = จำนวน agent 
       //  -p = package(starter/S/M/L) 
       //  -t = demo flag (DEMO/package)
       //  -e = customer email 
       //  -tz = timezone (Asia/Bangkok)*/
        putenv('AWS_DEFAULT_REGION=ap-southeast-1');
        putenv('AWS_ACCESS_KEY_ID=AKIAUNHYTT7SA2B3W3KG');
        putenv('AWS_SECRET_ACCESS_KEY=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');
        $output = shell_exec($scripts); 
        echo "<pre>$output</pre>";
        $scriptoutput =  "<pre>$output</pre>";
       // //  //log call script
        Log::channel('callfreescript')->info('script',['data' => $scripts,'output' => $scriptoutput]);
      
        $urlckcurl = 'http://'.$username.'.netkadev.com/shared/checkempty';//'http://'.$username.'.itsmnetka.com/Login';
        

        
        $i=10;
        $k=0;
        $httpcode = "";
        while($k<=$i){
           ini_set('max_execution_time', 300); // prevents 30 seconds from being fatal

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 200); // curl timeout remains at 3 minus
            curl_setopt($ch, CURLOPT_URL, $urlckcurl);
            $data = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch); 

            if($httpcode<>200){
                sleep(60);
                Log::channel('checkhttpstatus')->info('statussleep',[$httpcode]);
            }else{
                Log::channel('checkhttpstatus')->info('statuspass',[$httpcode]);
                break;
            }

            $k++;
        }
        
        Log::channel('checkhttpstatus')->info('status',[$httpcode]);
        
        
        if($httpcode=="200"){
            Log::channel('checkhttpstatus')->info('status200',[$httpcode]);

            $to_name = $username;
            $to_email = $email;
            $data = array('name'=> $username,
                               "servicelink" => "https://".$username.".netkadev.com",
                                "agent" => $agent,
                                "package" => $planpackage,
                                "expire" => $expireformat,
                                "genpass" => $newpassword,
                                "start"=> $startformat,
                                "licenseno" => $licenseno);
            Mail::send(array('html' => 'mail'), $data, function($message) use ($to_name, $to_email) {
                  $message->to($to_email, $to_name)
                          ->subject('Your NetkaQuartz Service Desk X on Cloud is ready to use.');
                  $message->from('itsm@netkasystem.com','Your NSDX SaaS Ready');
            });
        }
        
    }

    //response case upgrade plan only = payment normal only 2c2p
    public function responsebackupgrades(Request $request){
      $all = $request->all();
      //Log::channel('eventy')->info('info1',['data' => $all]);
      Log::channel('upgrade')->info('info-upgrade',['data' => $all]);
      // exit;

      $list = explode(':',$all['user_defined_2']); 
      $detail_upgrade = $all['user_defined_3']; //detail upgrade from xx to xx
      $typee = $all['user_defined_1'];//type plan per day
      $response_orderid = $all['order_id'];// order id
      $find_oldorder = explode('O', $all['order_id']);
      $date_payment = substr($find_oldorder[0], -8); //date pay
      $old_order = $find_oldorder[1]; //old order id 
      $cut_fix = substr($find_oldorder[0], 1); //cut Fix U out
      // $order_subscript = substr($cut_fix, 0,-8); //order is subscription cut time out
      $order_subscript = substr(substr($cut_fix, 0,-8) ,0,-6); //order is subscription
      $sitename = $list[0]; //user sitename
      $customer_email =  $list[4]; //customer email
      $amount_difference = $all['amount']; //amount pay diff

      
      $today = date("Y-m-d");
      $date1 = str_replace('-', '/', $today);
      $newpassword = '';//$this->GenerateStrongPassword(); //16 digit
      $region = strtoupper( trim($list[5]) );
      $country = strtoupper( trim($list[6]) );
      // timezone
      $timezones = $this->ckregion( $region, $country );
        if( is_null($timezones) ){
            $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $list[0] .' -n '. $list[2] . ' -p '. $list[1] . ' -t ' . $list[3] .' -e ' .$list[4].' -u '.$newpassword.' -rp 0';//.$typee;
        }else{
           $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $list[0] .' -n '. $list[2] . ' -p '. $list[1] . ' -t ' . $list[3] .' -e ' .$list[4].' -u '.$newpassword.' -tz '.$timezones.' -rp 0';//.$typee;
        }

        //call script change package
        /* -i = instance(customerid)
          -n = จำนวน agent 
          -p = package(starter/S/M/L) 
          -t = demo flag (DEMO/package)
          -e = customer email 
          -tz = timezone (Asia/Bangkok)
          -rp = days for expire*/
          putenv('AWS_DEFAULT_REGION=ap-southeast-1');
          putenv('AWS_ACCESS_KEY_ID=AKIAUNHYTT7SA2B3W3KG');
          putenv('AWS_SECRET_ACCESS_KEY=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');
          $output = shell_exec($scripts); 
          // echo "<pre>$output</pre>";
          $scriptoutput =  "<pre>$output</pre>";
          //log call script
          Log::channel('scriptupgrade')->info('script',['data' => $scripts,'output' => $scriptoutput]);

          $datapost = json_encode( array( 'type_pay' => 'upgrade',
                        'old_order' => $old_order,
                        'subscription_order' => $order_subscript,
                        'cus_email' => $customer_email,
                        'detail_upgrade' => $detail_upgrade,
                        'res_recurring' => $all
                      ) );

//var_dump($datapost);exit;
          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://staging2.netkasystem.com/itsmstore/api/upgrade-pay.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$datapost,
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);
          

        //curl send email receive upgrade plan
           $datapostupgrade = 'old_order='.$old_order.'&subscription_order='.$order_subscript.'&cus_email='.$customer_email.'&detail_upgrade='.$detail_upgrade.'&paydiff='.$amount_difference.'&order_id='.$response_orderid;

           $curl1 = curl_init();

            curl_setopt_array($curl1, array(
              CURLOPT_URL => 'https://staging2.netkasystem.com/itsmstore/api/receiveupgrade.php',//https://netkasystem.com/itsmstore/api/
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => $datapostupgrade,
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
              ),
            ));

          $response1 = curl_exec($curl1);

          curl_close($curl1);

          echo $response;

    }


   /*================  inquiry 2c2p ===================*/
    public function inquiry(Request $request){
      $all = $request->all();
      //Log
      Log::channel('inquiry')->info('info-inquiry',['data' => $all]);

      $type_inquiry = $all['type_inquiry'];
      
      // $find_unique = json_decode( $all['recurring_unique_id'] );
      // $recurring_unique_id = $find_unique->recurring_unique_id;
      $recurring_unique_id = $all['recurring_unique_id'];
      
      //Merchant's account information
      $merchantID = "764764000004784"; //env('MERCHANT_ID2C2P');   //Get MerchantID when opening account with 2C2P
      $secretKey = "D97EE54180CF124D12961DB49A21BBF4D6C1AE3A8545CF062DC0517EDD3A7F04"; //env('SECRET_KEY2C2P'); //Get SecretKey from 2C2P PGW Dashboard
      //production key
      // $secretKey = "DF6B6D630191EBAB3BB0DF6E2A35DCB11B8F7D7468E815E676570D86FE682833"; //Get SecretKey from 2C2P PGW Dashboard

      //check type for inquiry
      switch($type_inquiry){
        case "C": //cancel
          //Request Information  
          $version = "2.4";
          $processType = "C" ;
          $recurringUniqueID = $recurring_unique_id;   
          $recurringStatus = "";   
          $amount = "";  
          $allowAccumulate = "";   
          $maxAccumulateAmount= "";  
          $recurringInterval = "";   
          $recurringCount = "";  
          $chargeNextDate="";
          $chargeOnDate="";
          
          //Construct signature string
          $stringToHash = $version . $merchantID . $recurringUniqueID . $processType . $recurringStatus . $amount . $allowAccumulate . $maxAccumulateAmount . $recurringInterval . $recurringCount . $chargeNextDate . $chargeOnDate;
          $hash = strtoupper(hash_hmac('sha256', $stringToHash ,$secretKey, false));  //Compute hash value
        break;
        case "U": //update
          //Request Information  
          $version = "2.4";
          $processType = "U" ;
          $recurringUniqueID = $recurring_unique_id;   
          $recurringStatus = "";   
          $amount = $all['amount'];  
          $allowAccumulate = "N";   
          $maxAccumulateAmount= $all['amount'];  
          $recurringInterval = $all['intervals'];   
          $recurringCount = "99";  
          $chargeNextDate= $all['setdays'];
          $chargeOnDate="";
          
          //Construct signature string
          $stringToHash = $version . $merchantID . $recurringUniqueID . $processType . $recurringStatus . $amount . $allowAccumulate . $maxAccumulateAmount . $recurringInterval . $recurringCount . $chargeNextDate . $chargeOnDate;
          $hash = strtoupper(hash_hmac('sha256', $stringToHash ,$secretKey, false));  //Compute hash value
        break;
        default: //information
          //Request Information  
          $version = "2.4";
          $processType = "I" ;
          $recurringUniqueID = $recurring_unique_id;   
          $recurringStatus = "";   
          $amount = "";  
          $allowAccumulate = "";   
          $maxAccumulateAmount= "";  
          $recurringInterval = "";   
          $recurringCount = "";  
          $chargeNextDate="";
          $chargeOnDate="";
          
          //Construct signature string
          $stringToHash = $version . $merchantID . $recurringUniqueID . $processType . $recurringStatus . $amount . $allowAccumulate . $maxAccumulateAmount . $recurringInterval . $recurringCount . $chargeNextDate . $chargeOnDate;
          $hash = strtoupper(hash_hmac('sha256', $stringToHash ,$secretKey, false));  //Compute hash value
        break;
      }
      

      //Construct request message
      $xml = "<RecurringMaintenanceRequest>
          <version>$version</version> 
          <merchantID>$merchantID</merchantID>
          <recurringUniqueID>$recurringUniqueID</recurringUniqueID>
          <processType>$processType</processType>
          <recurringStatus>$recurringStatus</recurringStatus>
          <amount>$amount</amount>
          <allowAccumulate>$allowAccumulate</allowAccumulate>
          <maxAccumulateAmount>$maxAccumulateAmount</maxAccumulateAmount>
          <recurringInterval>$recurringInterval</recurringInterval>
          <recurringCount>$recurringCount</recurringCount>
          <chargeNextDate>$chargeNextDate</chargeNextDate>
          <chargeOnDate>$chargeOnDate</chargeOnDate>
          <hashValue>$hash</hashValue>
          </RecurringMaintenanceRequest>";  

      $payload = $this->encrypt2c2p($xml,"/var/www/html/newpayment/public/keys/demo2.crt"); //Encrypt payload
      //Log 
      Log::channel('inquiry_req')->info('info-inquiry',['data' => $payload]);
      
      //Send request to 2C2P PGW and get back response
      $url = "https://demo2.2c2p.com/2C2PFrontend/PaymentActionV2/PaymentAction.aspx"; //env('URL2C2P');
      //https://t.2c2p.com/RedirectV3/payment
      //prod
      // $url = "https://t.2c2p.com/RedirectV3/payment";
      $fields_string = "paymentRequest=".$payload;
      $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            //execute post
            $response = curl_exec($ch); //close connection
            curl_close($ch);

      $response =  $this->decrypt2c2p($response,"/var/www/html/newpayment/public/keys/demo2.crt","/var/www/html/newpayment/public/keys/demo2.pem","2c2p");
     
      //Log
      Log::channel('inquiry_res')->info('info-inquiry',['data' => $response]);
     
      //Validate response Hash
      $resXml=@simplexml_load_string($response); 
      $res_version = $resXml->version;
      $res_timeStamp = $resXml->timeStamp;
      $res_respCode = $resXml->respCode;
      $res_respReason = $resXml->respReason;
      $res_recurringUniqueID = $resXml->recurringUniqueID;
      $res_recurringStatus = $resXml->recurringStatus;
      $res_invoicePrefix = $resXml->invoicePrefix;
      $res_currency = $resXml->currency;
      $res_amount = $resXml->amount;
      $res_maskedCardNo = $resXml->maskedCardNo;
      $res_allowAccumulate = $resXml->allowAccumulate;
      $res_maxAccumulateAmount = $resXml->maxAccumulateAmount; 
      $res_recurringInterval = $resXml->recurringInterval;
      $res_recurringCount = $resXml->recurringCount; 
      $res_currentCount = $resXml->currentCount;
      $res_chargeNextDate = $resXml->chargeNextDate;
      $res_chargeOnDate = $resXml->chargeOnDate;
      
      
      //Compute response hash
      $res_stringToHash = $res_version . $res_respCode . $res_recurringUniqueID . $res_recurringStatus . $res_invoicePrefix . $res_currency . 
      $res_amount . $res_maskedCardNo . $res_allowAccumulate . $res_maxAccumulateAmount . $res_recurringInterval . $res_recurringCount . $res_currentCount . $res_chargeNextDate . $res_chargeOnDate;
      
      $res_responseHash = strtoupper(hash_hmac('sha256',$res_stringToHash,$secretKey, false));  //Compute hash value
      //echo "<br/>hash: ".$res_responseHash."<br/>"; 
      if(strtolower($resXml->hashValue) == strtolower($res_responseHash)){ 
        $msg =  "valid response"; 
        $err = "Success";
      }else{ 
        $msg =  "invalid response"; 
        $err = "Error";
      }
      
      echo json_encode( array("mscode"=>$err,"message"=>$msg) );
    }


    /* ===================== Downgrade ======================================= */
    public function downgrade(Request $request)
    {
      $all = $request->all();

      //Log
      Log::channel('downgrade_req')->info('info',['data' => $all]);

      $sitename = $all['sitename']; // -i
      $agents = $all['agent_down']; // -n
      $packages = $all['plan_down']; // -p
      $typepackages = $all['type_down']; //-t
      $customer_emails = $all['cus_email']; // -e
      $newpassword =  $all['passwords']; // -u
      $region = $all['region']; // TH
      $country = $all['country']; // TH-10 
      $intervals = $all['intervals']; // number of days
      // timezone
      $timezones = $this->ckregion( $region, $country );
        if( is_null($timezones) ){
            $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $sitename .' -n '. $agents . ' -p '. $packages . ' -t ' . $typepackages .' -e ' .$customer_emails.' -u '.$newpassword.' -rp 0';//.$typee;
        }else{
           $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $sitename .' -n '. $agents . ' -p '. $packages . ' -t ' . $typepackages .' -e ' .$customer_emails.' -u '.$newpassword.' -tz '.$timezones.' -rp 0';//.$typee;
        }

        //call script change package
        /* -i = instance(customerid)
          -n = จำนวน agent 
          -p = package(starter/S/M/L) 
          -t = demo flag (DEMO/package)
          -e = customer email
          -u = password 
          -tz = timezone (Asia/Bangkok)
          -rp = days for expire*/
          putenv('AWS_DEFAULT_REGION=ap-southeast-1');
          putenv('AWS_ACCESS_KEY_ID=AKIAUNHYTT7SA2B3W3KG');
          putenv('AWS_SECRET_ACCESS_KEY=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');
          $output = shell_exec($scripts); 
          // echo "<pre>$output</pre>";
          $scriptoutput =  "<pre>$output</pre>";
          //log call script
          Log::channel('scriptdowngrade')->info('script',['data' => $scripts,'output' => $scriptoutput]);

          echo json_encode( array("mscode"=>'Success',"message"=>"successful") );
    }




    // Generates a strong password of N length containing at least one lower case letter,
    // one uppercase letter, one digit, and one special character. The remaining characters
    // in the password are chosen at random from those four sets.
    //
    // The available characters in each set are user friendly - there are no ambiguous
    // characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
    // makes it much easier for users to manually type or speak their passwords.
    //
    // Note: the $add_dashes option will increase the length of the password by
    // floor(sqrt(N)) characters.

    public function GenerateStrongPassword($length = 8, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        // if(strpos($available_sets, 's') !== false)
        //     $sets[] = '!@#$%&*?';

        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        if(!$add_dashes)
            return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

// check region more
    public function ckregion( $region , $city){

      switch( $region ){
        case "AF":
          return "Asia/Kabul";
        break;
        case "AX":
          return "Europe/Mariehamn";
        break;
        case "AL":
          return "Europe/Tirane";
        break;
        case "DZ":
          return "Africa/Algiers";
        break;
        case "AS":
          return "Pacific/Pago_Pago";
        break;
        case "AD":
          return "Europe/Andorra";
        break;
        case "AO":
          return "Africa/Luanda";
        break;
        case "AI":
          return "America/Anguilla";
        break;
        case "AQ":
          return"";
        break;
        case "AG":
          return "America/Antigua";
        break;
        case "AR":
          return "America/Argentina/Buenos_Aires";
        break;
        case "AM":
          return "Asia/Yerevan";
        break;
        case "AW":
          return "America/Aruba";
        break;
        case "AU":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "ACT":
                return "Australia/ACT";
              break;
              case "NSW":
                return "Australia/Broken_Hill";
              break;
              case "NT":
                return "Australia/Darwin";
              break;
              case "QLD":
                return "Australia/Brisbane";
              break;
              case "SA":
                return "Australia/Adelaide";
              break;
              case "TAS":
               return " Australia/Hobart";
              break;
              case "VIC":
                return "Australia/Melbourne";
              break;
              case "WA":
                return "Australia/Perth";
              break;
            }
        break;
        case "AT":
          return "Europe/Vienna";
        break;
        case "AZ":
          return "Asia/Baku";
        break;
        case "BS":
          return "America/Nassau";
        break;
        case "BH":
          return "Asia/Bahrain";
        break;
        case "BD":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "BAGERHAT":
              case "BAG":
              case "Bandarban":
              case "BAN":
              case "Barguna":
              case "BAR":
              case "BARI":
              case "BHO":
              case "BOG":
              case "BRA":
              case "CHA":
              case "CHI":
              case "CHU":
              case "COM":
              case "COX":
              case "DHA":
              case "DIN":
              case "FAR":
              case "FEN":
              case "GAI":
              case "GAZI":
              case "GOP":
              case "HAB":
              case "JAM":
              case "JES":
              case "JHA":
              case "JHE":
              case "JOY":
              case "KHA":
              case "KHU":
              case "KIS":
              case "KUR":
              case "KUS":
              case "LAK":
              case "LAL":
              case "MAD":
              case "MAG":
              case "MAN":
              case "MEH":
              case "MOU":
              case "MUN":
              case "MYM":
              case "NAO":
              case "NAR":
              case "NARG":
              case "NARD":
              case "NAT":
              case "NAW":
              case "NET":
              case "NIL":
              case "NOA":
              case "PAB":
              case "PAN":
              case "PAT":
              case "PIR":
              case "RAJB":
              case "RAJ":
              case "RAN":
              case "RANP":
              case "SAT":
              case "SHA":
              case "SHE":
              case "SIR":
              case "SUN":
              case "SYL":
              case "TAN":
              case "THA":
                return "Asia/Dhaka";
              break;
            }
        break;
        case "BB":
          return "America/Barbados";
        break;
        case "BY":
          return "Europe/Minsk";
        break;
        case "BE":
          return "Europe/Brussels";
        break;
        case "PW":
          return "Pacific/Palau";
        break;
        case "BZ":
          return "America/Belize";
        break;
        case "BJ":
          return "Africa/Porto-Novo";
        break;
        case "BM":
          return "Atlantic/Bermuda";
        break;
        case "BT":
          return "Asia/Thimphu";
        break;
        case "BO":
          return "America/La_Paz";
        break;
        case "BQ":
          return "America/Kralendijk";
        break;
        case "BA":
          return "Europe/Sarajevo";
        break;
        case "BW":
          return "Africa/Gaborone";
        break;
        case "BV":
          return "America/Noronha";//Central European Time
        break;
        case "BR":
          //return$this->cktimezone($city);
          switch($city)
          {
            case "AC":
              return "America/Rio_Branco";
            break;
            case "AL":
              return "America/Maceio";
            break;
            case "AP":
              return "America/Belem";
            break;
            case "AM":
              return "America/Eirunepe";
            break;
            case "BA":
              return "America/Bahia";
            break;
            case "CE":
            case "MA":
            case "PB":
            case "PI":
            case "RN":
              return "America/Fortaleza";
            break;
            case "DF":
            case "GO":
            case "ES":
            case "MG":
            case "PR":
            case "RJ":
            case "RS":
            case "SC":
            case "SP":
              return "America/Sao_Paulo";
            break;
            case "MT":
              return "America/Campo_Grande";
            break;
            case "MS":
              return "America/Campo_Grande";
            break;
            case "PA":
              return "America/Santarem";
            break;
            case "PE":
              return "America/Recife";
            break;
            case "RO":
              return "America/Porto_Velho";
            break;
            case "RR":
              return "America/Boa_Vista";
            break;
            case "SE":
              return "America/Maceio";
            break;
            case "TO":
              return "America/Araguaina";
            break;
          }
        break;
        case "IO":
          return "Indian/Chagos";
        break;
        case "VG":
          return "America/Tortola";
        break;
        case "BN":
          return "Asia/Brunei";
        break;
        case "BG":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "BG-01":
              case "BG-02":
              case "BG-08":
              case "BG-07":
              case "BG-26":
              case "BG-09":
              case "BG-10":
              case "BG-11":
              case "BG-12":
              case "BG-13":
              case "BG-14":
              case "BG-15":
              case "BG-16":
              case "BG-17":
              case "BG-18":
              case "BG-27":
              case "BG-19":
              case "BG-20":
              case "BG-21":
              case "BG-23":
              case "BG-22":
              case "BG-24":
              case "BG-25":
              case "BG-03":
              case "BG-04":
              case "BG-05":
              case "BG-06":
              case "BG-28":
                return "Europe/Sofia";
              break;
            }
        break;
        case "BF":
          return "Africa/Ouagadougou";
        break;
        case "BI":
          return "Africa/Bujumbura";
        break;
        case "KH":
          return "Asia/Phnom_Penh";
        break;
        case "CM":
          return "Africa/Douala";
        break;
        case "CA":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "AB":
               return "America/Edmonton";
              break;
              case "BC":
                return "America/Vancouver";
              break;
              case "MB":
                return "America/Winnipeg";
              break;
              case "NB":
                return "America/Moncton";
              break;
              case "NL":
                return "America/St_Johns";
              break;
              case "NT":
                return "America/Yellowknife";
              break;
              case "NS":
              case "PE":
                return "America/Halifax";
              break;
              case "NU":
                return "America/Iqaluit";
              break;
              case "ON":
              case "QC":
                return "America/Toronto";
              break;
              case "SK":
                return "America/Regina";
              break;
              case "YT":
                return "America/Whitehorse";
              break;
            }
        break;
        case "CV":
          return "Atlantic/Cape_Verde";
        break;
        case "KY":
          return "America/Cayman";
        break;
        case "CF":
          return "Africa/Bangui";
        break;
        case "TD":
          return "Africa/Ndjamena";
        break;
        case "CL":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "SANTIAGO":
              case "CHILE":
                return "America/Santiago";
              break;
              case "PUNTA ARENAS":
                return "America/Punta_Arenas";
              break;
              case "EASTER ISLAND":
                return "Pacific/Easter";
              break;
              default:
                return "America/Santiago";
              break;
            }
        break;
        case "CN":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "CN1":
              case "CN2":
              case "CN3":
              case "CN4":
              case "CN5":
              case "CN6":
              case "CN7":
              case "CN8":
              case "CN9":
              case "CN10":
              case "CN11":
              case "CN12":
              case "CN13":
              case "CN14":
              case "CN15":
              case "CN16":
              case "CN17":
              case "CN18":
              case "CN19":
              case "CN20":
              case "CN21":
              case "CN22":
              case "CN23":
              case "CN24":
              case "CN25":
              case "CN26":
              case "CN27":
              case "CN28":
              case "CN29":
              case "CN31":
                return "Asia/Shanghai";
              break;
              case "CN30":
                return "Asia/Macau";
              break;
              case "CN32":
                return "Asia/Urumqi";
              break;
            }
        break;
        case "CX":
          return "Indian/Christmas";
        break;
        case "CC":
          return "Indian/Cocos";
        break;
        case "CO":
          return "America/Bogota";
        break;
        case "KM":
          return "Indian/Comoro";
        break;
        case "CG":
          return "Africa/Brazzaville";
        break;
        case "CD":
          return "Africa/Kinshasa";
        break;
        case "CK":
          return "Pacific/Rarotonga";
        break;
        case "CR":
          return "America/Costa_Rica";
        break;
        case "HR":
          return "Europe/Zagreb";
        break;
        case "CU":
          return "America/Havana";
        break;
        case "CW":
          return "America/Curacao";
        break;
        case "CY":
          return "Asia/Nicosia";
        break;
        case "CZ":
          return "Europe/Prague";
        break;
        case "DK":
          return "Europe/Copenhagen";
        break;
        case "DJ":
          return "Africa/Djibouti";
        break;
        case "DM":
          return "America/Dominica";
        break;
        case "DO":
          return "America/Santo_Domingo";
        break;
        case "EC":
          return "America/Guayaquil";
        break;
        case "EG":
          return "Africa/Cairo";
        break;
        case "SV":
          return "America/El_Salvador";
        break;
        case "GQ":
          return "Africa/Malabo";
        break;
        case "ER":
          return "Africa/Asmara";
        break;
        case "EE":
          return "Europe/Tallinn";
        break;
        case "ET":
          return "Africa/Addis_Ababa";
        break;
        case "FK":
          return "Atlantic/Stanley";
        break;
        case "FO":
          return "Atlantic/Faroe";
        break;
        case "FJ":
          return "Pacific/Fiji";
        break;
        case "FI":
          return "Europe/Helsinki";
        break;
        case "FR":
          return "Europe/Paris";
        break;
        case "GF":
          return "America/Cayenne";
        break;
        case "PF":
          return "Pacific/Tahiti";
        break;
        case "TF":
          return "Indian/Kerguelen";
        break;
        case "GA":
          return "Africa/Libreville";
        break;
        case "GM":
          return "Africa/Banjul";
        break;
        case "GE":
          return "Asia/Tbilisi";
        break;
        case "DE":
          return "Europe/Berlin";
        break;
        case "GH":
          return "Africa/Accra";
        break;
        case "GI":
          return "Europe/Gibraltar";
        break;
        case "GR":
          return "Europe/Athens";
        break;
        case "GL":
          return "America/Nuuk";
        break;
        case "GD":
          return "America/Grenada";
        break;
        case "GP":
          return "America/Guadeloupe";
        break;
        case "GT":
          return "America/Guatemala";
        break;
        case "GG":
          return "Europe/Guernsey";
        break;
        case "GN":
          return "Africa/Conakry";
        break;
        case "GW":
          return "Africa/Bissau";
        break;
        case "GY":
          return "America/Guyana";
        break;
        case "HT":
          return "America/Port-au-Prince";
        break;
        case "HM":
          return "Indian/Kerguelen";
        break;
        case "HN":
          return "America/Tegucigalpa";
        break;
        case "HK":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "HONG KONG":
              case "KOWLOON":
              case "NEW TERRITORIES":
                return "Asia/Hong_Kong";
              break;
            }
        break;
        case "HU":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "BK":
              case "BE":
              case "BA":
              case "BZ":
              case "BU":
              case "CS":
              case "FE":
              case "GS":
              case "HB":
              case "HE":
              case "JN":
              case "KE":
              case "NO":
              case "PE":
              case "SO":
              case "SZ":
              case "TO":
              case "VA":
              case "VE":
              case "ZA":
                return "Europe/Budapest";
              break;
            }
        break;
        case "IS":
          return "Atlantic/Reykjavik";
        break;
        case "IN":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "AP":
              case "AR":
              case "AS":
              case "BR":
              case "CT":
              case "GA":
              case "GJ":
              case "HR":
              case "HP":
              case "JK":
              case "JH":
              case "KA":
              case "KL":
              case "MP":
              case "MH":
              case "MN":
              case "ML":
              case "MZ":
              case "NL":
              case "OR":
              case "PB":
              case "RJ":
              case "SK":
              case "TN":
              case "TR":
              case "UK":
              case "UP":
              case "WB":
              case "AN":
              case "CH":
              case "DN":
              case "DD":
              case "DL":
              case "LD":
              case "PY":
                return "Asia/Kolkata";
              break;
            }
        break;
        case "ID":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "AC":
              case "SU":
              case "SB":
              case "RI":
              case "JA":
              case "SS":
              case "BB":
              case "BE":
              case "LA":
              case "JK":
              case "JB":
              case "BT":
              case "JT":
              case "JI":
              case "YO":
                return "Asia/Jakarta";
              break;
              case "KR":
              case "KB":
              case "KT":
                return "Asia/Pontianak";
              break;
              case "BA":
              case "NB":
              case "NT":
              case "KI":
              case "KS":
              case "KU":
              case "SA":
              case "ST":
              case "SG":
              case "SR":
              case "SN":
              case "GO":
                return "Asia/Makassar";
              break;
              case "MA":
              case "MU":
              case "PA":
              case "PB":
                return "Asia/Jayapura";
              break;
            }
        break;
        case "IR":
          return "Asia/Tehran";
        break;
        case "IQ":
          return "Asia/Baghdad";
        break;
        case "IE":
          return "Europe/Dublin";
        break;
        case "IM":
          return "Europe/Isle_of_Man";
        break;
        case "IL":
          return "Asia/Jerusalem";
        break;
        case "IT":
          //return$this->cktimezone($city);
          return "Europe/Rome";
        break;
        case "CI":
          return "Africa/Abidjan";
        break;
        case "JM":
          return "America/Jamaica";
        break;
        case "JP":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "JP01":
              case "JP02":
              case "JP03":
              case "JP04":
              case "JP05":
              case "JP06":
              case "JP07":
              case "JP08":
              case "JP09":
              case "JP10":
              case "JP11":
              case "JP12":
              case "JP13":
              case "JP14":
              case "JP15":
              case "JP16":
              case "JP17":
              case "JP18":
              case "JP19":
              case "JP20":
              case "JP21":
              case "JP22":
              case "JP23":
              case "JP24":
              case "JP25":
              case "JP26":
              case "JP27":
              case "JP28":
              case "JP29":
              case "JP30":
              case "JP31":
              case "JP32":
              case "JP33":
              case "JP34":
              case "JP35":
              case "JP36":
              case "JP37":
              case "JP38":
              case "JP39":
              case "JP40":
              case "JP41":
              case "JP42":
              case "JP43":
              case "JP44":
              case "JP45":
              case "JP46":
              case "JP47":
                return "Asia/Tokyo";
              break;
            }
        break;
        case "JE":
          return "Europe/Jersey";
        break;
        case "JO":
          return "Asia/Amman";
        break;
        case "KZ":
          return "Asia/Almaty";
        break;
        case "KE":
          return "Africa/Nairobi";
        break;
        case "KI":
          return "Pacific/Tarawa";
        break;
        case "KW":
          return "Asia/Kuwait";
        break;
        case "KG":
          return "Asia/Bishkek";
        break;
        case "LA":
          return "Asia/Vientiane";
        break;
        case "LV":
          return "Europe/Riga";
        break;
        case "LB":
          return "Asia/Beirut";
        break;
        case "LS":
          return "Africa/Maseru";
        break;
        case "LR":
          return "Africa/Monrovia";
        break;
        case "LY":
          return "Africa/Tripoli";
        break;
        case "LI":
          return "Europe/Vaduz";
        break;
        case "LT":
          return "Europe/Vilnius";
        break;
        case "LU":
          return "Europe/Luxembourg";
        break;
        case "MO":
          return "Asia/Macau";
        break;
        case "MK":
          return "Europe/Skopje";
        break;
        case "MG":
          return "Indian/Antananarivo";
        break;
        case "MW":
          return "Africa/Blantyre";
        break;
        case "MY":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "JHR":
              case "KDH":
              case "KTN":
              case "MLK":
              case "NSN":
              case "PHG":
              case "PRK":
              case "PLS":
              case "PNG":
              case "SGR":
              case "TRG":
              case "KUL":
              case "PJY":
                return "Asia/Kuala_Lumpur";
              break;
              case "SBH":
              case "SWK":
              case "LBN":
                return "Asia/Kuching";
              break;
            }
        break;
        case "MV":
          return "Indian/Maldives";
        break;
        case "ML":
          return "Africa/Bamako";
        break;
        case "MT":
          return "Europe/Malta";
        break;
        case "MH":
          return "Pacific/Majuro";
        break;
        case "MQ":
          return "America/Martinique";
        break;
        case "MR":
          return "Africa/Nouakchott";
        break;
        case "MU":
          return "Indian/Mauritius";
        break;
        case "YT":
          return "Indian/Mayotte";
        break;
        case "MX":
          return "America/Mexico_City";
        break;
        case "FM":
          return "Pacific/Chuuk";
        break;
        case "MD":
          return"Europe/Chisinau";
        break;
        case "MC":
          return "Europe/Monaco";
        break;
        case "MN":
          return "Asia/Ulaanbaatar";
        break;
        case "ME":
          return "Europe/Podgorica";
        break;
        case "MS":
          return "America/Montserrat";
        break;
        case "MA":
          return "Africa/Casablanca";
        break;
        case "MZ":
          return "Africa/Maputo";
        break;
        case "MM":
          return "Asia/Yangon";
        break;
        case "NA":
          return "Africa/Windhoek";
        break;
        case "NR":
          return "Pacific/Nauru";
        break;
        case "NP":
          return "Asia/Kathmandu";
        break;
        case "NL":
          return "Europe/Amsterdam";
        break;
        case "AN":
          return "America/Toronto";
        break;
        case "NC":
          return "Pacific/Noumea";
        break;
        case "NZ":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "NL":
              case "AK":
              case "WA":
              case "BP":
              case "TK":
              case "HB":
              case "MW":
              case "WE":
              case "NS":
              case "MB":
              case "TM":
              case "WC":
              case "CT":
              case "OT":
              case "SL":
                return "Pacific/Auckland";
              break;
            }
        break;
        case "NI":
          return "America/Managua";
        break;
        case "NE":
          return "Africa/Niamey";
        break;
        case "NG":
          return "Africa/Lagos";
        break;
        case "NU":
          return "Pacific/Niue";
        break;
        case "NF":
          return "Pacific/Norfolk";
        break;
        case "KP":
          return "Asia/Pyongyang";
        break;
        case "NO":
          return "Europe/Oslo";
        break;
        case "OM":
          return "Asia/Muscat";
        break;
        case "PK":
          return "Asia/Karachi";
        break;
        case "PS":
          return "Asia/Hebron";
        break;
        case "PA":
          return "America/Panama";
        break;
        case "PG":
          return "Pacific/Port_Moresby";
        break;
        case "PY":
          return "America/Asuncion";
        break;
        case "PE":
          return "America/Lima";
        break;
        case "PH":
          return "Asia/Manila";
        break;
        case "PN":
          return "Pacific/Pitcairn";
        break;
        case "PL":
          return "Europe/Warsaw";
        break;
        case "PT":
          return "Europe/Lisbon";
        break;
        case "QA":
          return "Asia/Qatar";
        break;
        case "RE":
          return "Indian/Reunion";
        break;
        case "RO":
          return "Europe/Bucharest";
        break;
        case "RU":
          return "Asia/Tomsk";
        break;
        case "RW":
          return "Africa/Kigali";
        break;
        case "BL":
          return "America/St_Barthelemy";
        break;
        case "SH":
          return "Atlantic/St_Helena";
        break;
        case "KN":
          return "America/St_Kitts";
        break;
        case "LC":
          return "America/St_Lucia";
        break;
        case "MF":
          return "America/Marigot";
        break;
        case "SX":
          return "America/Lower_Princes";
        break;
        case "PM":
          return "America/Miquelon";
        break;
        case "VC":
          return "America/St_Vincent";
        break;
        case "SM":
          return "Europe/San_Marino";
        break;
        case "ST":
          return "Africa/Sao_Tome";
        break;
        case "SA":
          return "Asia/Riyadh";
        break;
        case "SN":
          return "Africa/Dakar";
        break;
        case "RS":
          return "Europe/Belgrade";
        break;
        case "SC":
          return "Indian/Mahe";
        break;
        case "SL":
          return "Africa/Freetown";
        break;
        case "SG":
          return "Asia/Singapore";
        break;
        case "SK":
          return "Europe/Bratislava";
        break;
        case "SI":
          return "Europe/Ljubljana";
        break;
        case "SB":
          return "Pacific/Guadalcanal";
        break;
        case "SO":
          return "Africa/Mogadishu";
        break;
        case "ZA":
          return "Africa/Johannesburg";
        break;
        case "GS":
          return "Atlantic/South_Georgia";
        break;
        case "KR":
          return "Asia/Seoul";
        break;
        case "SS":
          return "Africa/Juba";
        break;
        case "ES":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "C":
              case "VI":
              case "AB":
              case "A":
              case "AL":
              case "O":
              case "AV":
              case "BA":
              case "PM":
              case "B":
              case "BU":
              case "CC":
              case "CA":
              case "S":
              case "CS":
              case "CR":
              case "CO":
              case "CU":
              case "GI":
              case "GR":
              case "GU":
              case "SS":
              case "H":
              case "HU":
              case "J":
              case "LO":
              case "LE":
              case "L":
              case "LU":
              case "M":
              case "MA":
              case "MU":
              case "NA":
              case "OR":
              case "P":
              case "PO":
              case "SA":
              case "SG":
              case "SE":
              case "SO":
              case "T":
              case "TE":
              case "TO":
              case "V":
              case "VA":
              case "BI":
              case "ZA":
              case "Z":
                return "Europe/Madrid";
              break;
              case "CE":
              case "ML":
                return "Africa/Ceuta";
              break;
              case "GC":
              case "TF":
                return "Atlantic/Canary";
              break;
            }
        break;
        case "LK":
          return "Asia/Colombo";
        break;
        case "SD":
          return "Africa/Khartoum";
        break;
        case "SR":
          return "America/Paramaribo";
        break;
        case "SJ":
          return "Arctic/Longyearbyen";
        break;
        case "SZ":
          return "Africa/Mbabane";
        break;
        case "SE":
          return "Europe/Stockholm";
        break;
        case "CH":
          return "Europe/Zurich";
        break;
        case "SY":
          return "Asia/Damascus";
        break;
        case "TW":
          return "Asia/Taipei";
        break;
        case "TJ":
          return "Asia/Dushanbe";
        break;
        case "TZ":
          return "Africa/Dar_es_Salaam";
        break;
        case "TH":
          return "Asia/Bangkok";
        break;
        case "TL":
          return "Asia/Dili";
        break;
        case "TG":
          return "Africa/Lome";
        break;
        case "TK":
          return "Pacific/Fakaofo";
        break;
        case "TO":
          return "Pacific/Tongatapu";
        break;
        case "TT":
          return "America/Port_of_Spain";
        break;
        case "TN":
          return "Africa/Tunis";
        break;
        case "TR":
          return "Europe/Istanbul";//$this->cktimezone($city);
        break;
        case "TM":
          return "Asia/Ashgabat";
        break;
        case "TC":
          return "America/Grand_Turk";
        break;
        case "TV":
          return "Pacific/Funafuti";
        break;
        case "UG":
          return "Africa/Kampala";
        break;
        case "UA":
          return "Europe/Kiev";
        break;
        case "AE":
          return "Asia/Dubai";
        break;
        case "GB":
          return "Europe/London";
        break;
        case "US":
          //return$this->cktimezone($city);
            switch($city)
            {
              case "AL":
              case "AR":
              case "IL":
              case "IA":
              case "KS":
              case "LA":
              case "MN":
              case "MS":
              case "MO":
              case "NE":
              case "ND":
              case "OK":
              case "SD":
              case "TN":
              case "TX":
              case "VA":
              case "WI":
              case "AA":
              case "AE":
              case "AP":
                return "America/Chicago";
              break;
              case "AK":
                return "America/Anchorage";
              break;
              case "AZ":
                return "America/Phoenix";
              break;
              case "CA":
              case "NV":
                return "America/Los_Angeles"; 
              break;
              case "CO":
              case "MT":
              case "NM":
              case "UT":
                return "America/Denver";
              break;
              case "CT":
              case "DE":
              case "DC":
              case "FL":
              case "GA":
              case "IN":
              case "ME":
              case "MD":
              case "MA":
              case "NH":
              case "NJ":
              case "NY":
              case "NC":
              case "OH":
              case "OR":
              case "PA":
              case "RI":
              case "SC":
              case "VT":
              case "WA":
              case "WV":
                return "America/New_York";
              break;
              case "HI":
                return "Pacific/Honolulu";
              break;
              case "ID":
                return "America/Boise";
              break;
              case "KY":
                return "America/Kentucky/Louisville";
              break;
              case "MI":
              case "WY":
                return "America/Detroit";
              break;
              case "AS":
                return "Pacific/Pago_Pago";
              break;
              case "GU":
                return "Pacific/Guam";
              break;
              case "MP":
                return "Pacific/Saipan";
              break;
              case "PR":
                return "America/Puerto_Rico";
              break;
              case "UM":
                return "Pacific/Wake";
              break;
              case "VI":
                return "America/St_Thomas";
              break;
            }
        break;
        case "UY":
          return "America/Montevideo";
        break;
        case "UZ":
          return "Asia/Tashkent";
        break;
        case "VU":
          return "Pacific/Efate";
        break;
        case "VA":
          return "Europe/Vatican";
        break;
        case "VE":
          return "America/Caracas";
        break;
        case "VN":
          return "Asia/Ho_Chi_Minh";
        break;
        case "WF":
          return "Pacific/Wallis";
        break;
        case "EH":
          return "Africa/El_Aaiun";
        break;
        case "WS":
          return "Pacific/Apia";
        break;
        case "YE":
          return "Asia/Aden";
        break;
        case "ZM":
          return "Africa/Lusaka";
        break;
        case "ZW":
          return "Africa/Harare";
        break;
        // default:
        //   return "Asia/Bangkok";
        // break;
      }

    }

  /*===================== start function encrypt decrypt 2c2p ==============================*/
  private  function encrypt2c2p($text,$publickey)
  {
    //write text to file
    if(!file_exists( dirname(__FILE__)."/tmp/"))
    {
      mkdir( dirname(__FILE__)."/tmp/");
    }
    $filename = dirname(__FILE__)."/tmp/".time().".txt";
    $this->text_to_file($text,$filename);
    $filename_enc = dirname(__FILE__)."/tmp/".time().".enc";
      
    $key = file_get_contents($publickey);
    if (openssl_pkcs7_encrypt($filename, $filename_enc, $key,
    array())) {
        // message encrypted - send it!
      unlink($filename);
      if (!$handle = fopen($filename_enc, 'r')) {
               echo "Cannot open file ($filename_enc)";
               exit;
          }
        
        $contents = fread($handle, filesize($filename_enc));
        fclose($handle);
        $contents = str_replace("MIME-Version: 1.0
Content-Disposition: attachment; filename=\"smime.p7m\"
Content-Type: application/pkcs7-mime; smime-type=enveloped-data; name=\"smime.p7m\"
Content-Transfer-Encoding: base64
","",$contents);
        $contents = str_replace("\n","",$contents);
        unlink($filename_enc);
        return $contents;
    }
  }
  
  private function decrypt2c2p($text,$publickey,$privatekey,$password)
  {
    $arr = str_split($text,64);
    $text = "";
    foreach($arr as $val)
    {
      $text .= $val."\n";
    }
    
    $text = "MIME-Version: 1.0
Content-Disposition: attachment; filename=\"smime.p7m\"
Content-Type: application/pkcs7-mime; smime-type=enveloped-data; name=\"smime.p7m\"
Content-Transfer-Encoding: base64

".$text;
    $text = rtrim($text,"\n");
    if(!file_exists( dirname(__FILE__)."/tmp/"))
    {
      mkdir( dirname(__FILE__)."/tmp/");
    }

    $infilename = dirname(__FILE__)."/tmp/".time().".txt";
    $this->text_to_file($text,$infilename);
        // echo $infilename;exit;
    $outfilename = dirname(__FILE__)."/tmp/".time().".dec";
    
    $public = file_get_contents($publickey);
    
    $private = array(file_get_contents($privatekey), $password);

    if (openssl_pkcs7_decrypt($infilename, $outfilename, $public, $private)) {
      unlink($infilename);
      $content = file_get_contents($outfilename);
      unlink($outfilename);
      return $content;
    }
    else{
      unlink($outfilename);
      unlink($infilename);
      echo "DECRYPT FAIL";exit;
    }
  }
  
  private function text_to_file($text,$filename)
  {
    if (!$handle = fopen($filename, 'w')) {
             echo "Cannot open file ($filename)";
             exit;
        }
      
        // Write $somecontent to our opened file.
        if (fwrite($handle, $text) === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }
  }
  /*============================================================================================*/


  /* ============================= for manual ============================================= */

  public function createmanual(Request $request){
    $all = $request->all();
    Log::channel('manualcreate')->info('info',['data' => $all]);
    //check param
    if( empty($all) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires all param.') );
      exit();
    }
    if( empty($all['version']) || $all['version'] <> 'manual'){
      echo json_encode( array('mscode'=>'error','message'=>'Requires version or version  mismatch.') );
      exit();
    }
    if( empty($all['period_day']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires days.') );
      exit();
    }
    if( empty($all['domain_name']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires domain_name.') );
      exit();
    }
    if( empty($all['package']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires package.') );
      exit();
    }
    if( empty($all['agent']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires agent.') );
      exit();
    }
    if( empty($all['email']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires email.') );
      exit();
    }
    if( empty($all['region']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires region code.') );
      exit();
    }
    if( empty($all['contry']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires contry code.') );
      exit();
    }
    
    //exit;
    $sitename = $all['domain_name'];
    $typee = $all['period_day']; //day expirce
    $package = $all['package'];
    $agent = $all['agent'];
    $email = $all['email'];
    $region = $all['region'];
    $country = $all['contry'];
    $today = date("Y-m-d");
    $date1 = str_replace('-', '/', $today);
    $newpassword = $this->GenerateStrongPassword(); //16 digit
    $listdate = explode("-",$today);
    $listmonth = str_pad($listdate[1], 3, '0', STR_PAD_LEFT);
    $listdate1 = str_pad($listdate[2], 3, '0', STR_PAD_LEFT);
    $licenseno = 'NSDXSaaS'.$listdate1.$listmonth.$listdate[0];
    // timezone
    $timezones = $this->ckregion( $region, $country );
      if( is_null($timezones) ){
         $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $sitename .' -n '. $agent . ' -p '. $package . ' -t ' . $package .' -e ' .$email.' -u '.$newpassword.' -rp '.$typee;
      }else{
         $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $sitename .' -n '. $agent . ' -p '. $package . ' -t ' . $package .' -e ' .$email.' -u '.$newpassword.' -tz '.$timezones.' -rp '.$typee;
      }
      
      //set exprice 
      switch ($package){
          case "DEMO"://free 30 day
              $nextday = $typee."days";
              $startformat = date('d F,Y',strtotime($date1));
              $expire = date('Y-m-d',strtotime($date1 . $nextday));
              $expireformat = date('d F,Y',strtotime($date1 . $nextday));
          break;
          default:// charge 1 year
              // $today = date("Y-m-d");
              // $date1 = str_replace('-', '/', $today);
              $startformat = date('d F,Y',strtotime($date1));
              $nextday = $typee."days";
              $expire = 'Expired to: '.date('Y-m-d',strtotime($date1 . $nextday));
              $expireformat = date('d F,Y',strtotime($date1 . $nextday));
          break;
      }

      //check plan
      switch ($package) {
        case 'S':
           $planpackage = "Growth";
          break;
        case 'M':
          $planpackage = "Pro";
          break;
        case 'L':
          $planpackage = "Enterprise";
          break;
        default:
          $planpackage = "Starter";
          break;
      }

        //call RDS /home/ec2-user/aws_provisioning
        //  $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $list[0] .' -n '. $list[2] . ' -p '. $list[1] . ' -t ' . $list[3] .' -e ' .$list[4].' -u '.$newpassword.' -tz '.$timezones;
          /*  -i = instance(customerid)
          -n = จำนวน agent 
          -p = package(starter/S/M/L) 
          -t = demo flag (DEMO/package)
          -e = customer email 
          -tz = timezone (Asia/Bangkok)
          -rp = days for expire*/
          putenv('AWS_DEFAULT_REGION=ap-southeast-1');
          putenv('AWS_ACCESS_KEY_ID=AKIAUNHYTT7SA2B3W3KG');
          putenv('AWS_SECRET_ACCESS_KEY=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');
          $output = shell_exec($scripts); 
          echo "<pre>$output</pre>";
          $scriptoutput =  "<pre>$output</pre>";
          //log call script
          Log::channel('callscriptmanual')->info('script',['data' => $scripts,'output' => $scriptoutput]);


          $urlckcurl = 'http://'.$sitename.'.netkadev.com/shared/checkempty';//'http://'.$username.'.itsmnetka.com/Login';
          $i=10;
          $k=0;
          $httpcode = "";
          while($k<=$i){
             ini_set('max_execution_time', 300); // prevents 30 seconds from being fatal

              $ch = curl_init();
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
              curl_setopt($ch, CURLOPT_TIMEOUT, 200); // curl timeout remains at 3 minus
              curl_setopt($ch, CURLOPT_URL, $urlckcurl);
              $data = curl_exec($ch);
              $curl_errno = curl_errno($ch);
              $curl_error = curl_error($ch);
              $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              curl_close($ch); 

              if($httpcode<>200){
                  sleep(60);
                  Log::channel('checkhttpstatusmanual')->info('statussleep',[$httpcode]);
              }else{
                  Log::channel('checkhttpstatusmanual')->info('statuspass',[$httpcode]);
                  break;
              }

              $k++;
          }

          Log::channel('checkhttpstatusmanual')->info('status',[$httpcode]);

          if($httpcode=="200"){
              Log::channel('checkhttpstatusmanual')->info('status200',[$httpcode]);

            $to_name = $sitename;
            $to_email = $email;
            $data = array('name'=> $sitename,
                         "servicelink" => "https://".$sitename.".netkadev.com",
                          "agent" => $agent,
                          "package" => $planpackage,
                          "expire" =>$expireformat,
                          "genpass" => $newpassword,
                          "start" => $startformat,
                          "licenseno" => $licenseno);
                 
            Mail::send(array('html' => 'mail'), $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                        ->subject('Your NetkaQuartz Service Desk X on Cloud is ready to use.');
                $message->from('itsm@netkasystem.com','Your NSDX SaaS Ready');
            });
          }

              echo json_encode( array('mscode'=>'Success','message'=>'successful') );
  }

  /* ========================= update package manual ==============================*/
  public function updatemanual(Request $request){
    $all = $request->all();
    Log::channel('updatemanual')->info('info',['data' => $all]);

    //check param
    if( empty($all) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires all param.') );
      exit();
    }
    if( empty($all['version']) || $all['version'] <> 'upgrade'){
      echo json_encode( array('mscode'=>'error','message'=>'Requires version or version  mismatch.') );
      exit();
    }
    if( empty($all['period_day']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires days.') );
      exit();
    }
    if( empty($all['domain_name']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires domain_name.') );
      exit();
    }
    if( empty($all['package']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires package.') );
      exit();
    }
    if( empty($all['agent']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires agent.') );
      exit();
    }
    if( empty($all['email']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires email.') );
      exit();
    }
    if( empty($all['region']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires region code.') );
      exit();
    }
    if( empty($all['contry']) ){
      echo json_encode( array('mscode'=>'error','message'=>'Requires contry code.') );
      exit();
    }
    //exit;

    $sitename = $all['domain_name'];
    $typee = $all['period_day']; //day expirce
    $package = $all['package'];
    $agent = $all['agent'];
    $email = $all['email'];
    $region = $all['region'];
    $country = $all['contry'];    
    $today = date("Y-m-d");
    $date1 = str_replace('-', '/', $today);
    $newpassword = '';//$this->GenerateStrongPassword(); //16 digit

    // timezone
    $timezones = $this->ckregion( $region, $country );
      if( is_null($timezones) ){
          $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $sitename .' -n '. $agent . ' -p '. $package . ' -t ' . $package .' -e ' .$email.' -u '.$newpassword.' -rp '.$typee;
      }else{
         $scripts = 'aws_provisioning/AWS_db_provisioning -i '. $sitename .' -n '. $agent . ' -p '. $package . ' -t ' . $package .' -e ' .$email.' -u '.$newpassword.' -tz '.$timezones.' -rp '.$typee;
      }

      //call script change package
      /* -i = instance(customerid)
        -n = จำนวน agent 
        -p = package(starter/S/M/L) 
        -t = demo flag (DEMO/package)
        -e = customer email 
        -tz = timezone (Asia/Bangkok)
        -rp = days for expire*/
        putenv('AWS_DEFAULT_REGION=ap-southeast-1');
        putenv('AWS_ACCESS_KEY_ID=AKIAUNHYTT7SA2B3W3KG');
        putenv('AWS_SECRET_ACCESS_KEY=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');
        $output = shell_exec($scripts); 
        // echo "<pre>$output</pre>";
        $scriptoutput =  "<pre>$output</pre>";
        //log call script
        Log::channel('scriptupgrademanual')->info('script',['data' => $scripts,'output' => $scriptoutput]);

        json_encode( array('mscode'=>'Success','message'=>'successful') );
  }


}//end class

 