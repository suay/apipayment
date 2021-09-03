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


class PaymentController extends Controller
{

    
 	 public function charge( Request $request )
    {
        
        if(empty( $request->input('amount') ) && (strpos($request->input('amount'), '.') != 2) ){
            return response()->json(['status'=>'error','message'=>'Amount parameter required.']);
        }

        if(empty( $request->input('cardnumber') )){
            return response()->json(['status'=>'error','message'=>'Card number parameter required.']);
        }

        if(empty( $request->input('cardname') )){
            return respone()->json(['status'=>'error','message'=>'Card name parameter required.']);
        }

        if(empty( $request->input('exdate') ) && (strpos($request->input('exdate'), '/') != 2) ){
            return response()->json(['status'=>'error','message'=>'Expiration date parameter required.']);
        }

        if(empty( $request->input('secode') )){
            return response()->json(['status'=>'error','message'=>'Security code parameter required.']);
        }


        $cardname =  $request->input('cardname');
        $cardnumber = $request->input('cardnumber');
        $exdate = $request->input('exdate');
        $secode = $request->input('secode');
        //find decimal 
        $ckamount = strpos($request->input('amount'), '.');//str_replace('.','', $request->input('amount') );
       
        if($ckamount==false){
          //ไม่ใส่ . ทศนิยม
          $setformat = number_format($request->input('amount'),2, '.', '');
          $amount = str_replace('.','', $setformat );
        }else{
            $setformat =  number_format($request->input('amount'),2, '.', '');
            $amount  = str_replace('.','', $setformat );
        }
        $country = $request->input('country');

        $expirdate = explode('/', $exdate);

        $isdata = 'card%5Bname%5D='.$cardname.'&card%5Bnumber%5D='.$cardnumber.'&card%5Bsecurity_code%5D='.$secode.'&card%5Bexpiration_month%5D='.$expirdate[0].'&card%5Bexpiration_year%5D='.$expirdate[1];
        // var_dump($isdata);
        // exit;

        $urltoken = env('OMISE_URL').'/tokens';
        $auth = base64_encode(env('PUBLICK_KEY'));


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $urltoken,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $isdata,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic '.$auth,
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

       
            
            $results = json_decode($response);
            
          
            if($results->object=="token"){

                $seturlcharge = env('OMISE_CHARGE').'/charges';

                $gettokens = $results->id;
                $order_id = explode('_',$results->card->id);
                

               $datapost = 'amount='.$amount.'&currency=THB&card='.$gettokens.'&description='.$order_id[2].'&return_uri='.env('RESPONSEBACK');
               $skey = base64_encode(env('SECRET_KEY'));
                //  ==== Charges ===//
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => $seturlcharge,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => $datapost,
                  CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic '.$skey,
                    'Content-Type: application/x-www-form-urlencoded'
                  ),
                ));

                $responsecharge = curl_exec($curl);

                curl_close($curl);
                $resultcharge = json_decode($responsecharge);
                // =======end Charges=====//

                if($resultcharge->object=='charge'){

                    $data = array(
                        'status' => $resultcharge->status,
                        'message' => $resultcharge->failure_message
                    );
                    
                    return view("/response", compact("data"));

                }else{

                    $dataerr = array(
                        'message' => $resultcharge->message
                    );

                    return view('/errorpage', compact("dataerr"));
                }
                
                
            }else{
                $dataerr = array(
                    'message' => $results->message
                );
                 return view('/errorpage', compact("dataerr"));
            }
           
           // return response()->json(['status'=>'error']);
        
        //echo $response;

    }


     /**
     * Show the application call complete.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function callcomplete(Request $request)
    {
        $all = $request->all();
        Log::channel('eventy')->info($all); 
       // Log::info('info1',['infos'=>$all]);
       // exit;
        

        // $all = '{
        //           "object": "event",
        //           "id": "evnt_test_56vp5pfwjf1fqjn4ryy",
        //           "livemode": false,
        //           "location": "/events/evnt_test_56vp5pfwjf1fqjn4ryy",
        //           "key": "charge.create",
        //           "created": "2017-02-03T13:52:54Z",
        //           "data": {
        //             "object": "charge",
        //             "id": "chrg_test_56vp5pdrw28e2sgyr51",
        //             "livemode": false,
        //             "location": "/charges/chrg_test_56vp5pdrw28e2sgyr51",
        //             "amount": 100000,
        //             "currency": "jpy",
        //             "description": "Charge for order 3947",
        //             "status": "successful",
        //             "capture": true,
        //             "authorized": true,
        //             "reversed": false,
        //             "paid": true,
        //             "transaction": "trxn_test_56vp5pfhp4tv1o8xp85",
        //             "source_of_fund": "card",
        //             "refunded": 0,
        //             "refunds": {
        //               "object": "list",
        //               "from": "1970-01-01T00:00:00+00:00",
        //               "to": "2017-02-03T13:52:54+00:00",
        //               "offset": 0,
        //               "limit": 20,
        //               "total": 0,
        //               "order": null,
        //               "location": "/charges/chrg_test_56vp5pdrw28e2sgyr51/refunds",
        //               "data": [

        //               ]
        //             },
        //             "return_uri": "http://www.example.com/orders/3947/complete",
        //             "offsite": null,
        //             "reference": "paym_test_56vp5pe0wpv1c02a2vg",
        //             "authorize_uri": "https://api.omise.co/payments/paym_test_56vp5pe0wpv1c02a2vg/authorize",
        //             "failure_code": null,
        //             "failure_message": null,
        //             "card": {
        //               "object": "card",
        //               "id": "card_test_56vp5nkjti9mi10tmlx",
        //               "livemode": false,
        //               "country": "us",
        //               "city": "Bangkok",
        //               "postal_code": "10320",
        //               "financing": "",
        //               "bank": "",
        //               "last_digits": "4242",
        //               "brand": "Visa",
        //               "expiration_month": 2,
        //               "expiration_year": 2019,
        //               "fingerprint": "uqEgwbY6J9JcS3z/H1/eDzZmxXacMWo2gT09m+kj//0=",
        //               "name": "JOHN DOE",
        //               "security_code_check": true,
        //               "created": "2017-02-03T13:52:45Z"
        //             },
        //             "customer": null,
        //             "ip": null,
        //             "dispute": null,
        //             "created": "2017-02-03T13:52:53Z"
        //           }
        //         }';
                $endjs = json_decode($all);
                $objectevent = $endjs->object;
                $idevent = $endjs->id;
                $datacharge = $endjs->data;


                //===== check charge complete ===//
                if($datacharge->status=='successful'){
                   // echo "successful";

                    //=============== call create server with package ==============//
                    $urlcre = env('URL_CREATESERV');
                    $data = array(
                    		'userid' => '',
                    		'start_date' => '',
                    		'end_date' => '',
                    		'' => ''
                    	);

	    //            	$curl = curl_init();

					// curl_setopt_array($curl, array(
					//   CURLOPT_URL => $urlcre,
					//   CURLOPT_RETURNTRANSFER => true,
					//   CURLOPT_ENCODING => '',
					//   CURLOPT_MAXREDIRS => 10,
					//   CURLOPT_TIMEOUT => 0,
					//   CURLOPT_FOLLOWLOCATION => true,
					//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					//   CURLOPT_CUSTOMREQUEST => 'POST',
					//   CURLOPT_POSTFIELDS => $data,
					// ));

					// $response = curl_exec($curl);

	    //             curl_close($curl);



                }else{
                    //log false
                    //echo "failed";
                    Log::channel('eventyfalse')->info('data status false'.$all);
                }

        
    }

    //===================== end payment omise ================================================================//

    //============================ start payment 2c2p =======================================================//

    public function charge2c2p(Request $request)
    {

    	//$urlpay = env('URL2C2P');
    	$secret_key = '7jYcp4FxFdf0';//env('SECRET_KEY2C2P');
    	$version = '8.5'; //
    	$merchant_id = 'JT01';//env('MERCHANT_ID2C2P'); //
    	$payment_description = $request->input('payment_description'); //
    	$order_id = $request->input('order_id'); //
    	$user_defined_1 = $request->input('user_defined_1'); //
    	$user_defined_2 = $request->input('user_defined_2'); //
    	$user_defined_3 = $request->input('user_defined_3'); //
    	$user_defined_4 = $request->input('user_defined_4'); //
    	$user_defined_5 = $request->input('user_defined_5'); //
    	$amount_noneset = $request->input('amount'); //
    	$currency = $request->input('currency');
    	$promotion = $request->input('promotion'); //
    	$customer_email =$request->input('customer_email'); //
    	$result_url_1 = 'http://localhost:8000/happypay/public/responsepage2c2p'; //responsepage2c2p
    	$result_url_2 = 'http://localhost:8000/happypay/public/api/responseback'; //
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
				$result_url_1 . $result_url_2 . $enable_store_card .
				$stored_card_unique_id . $request_3ds . $recurring .
				$order_prefix . $recurring_amount . $allow_accumulate .
				$max_accumulate_amount . $recurring_interval .
				$recurring_count . $charge_next_date. $charge_on_date .
				$payment_option . $ipp_interest_type . $payment_expiry .
				$default_lang . $statement_descriptor . $use_storedcard_only .
				$tokenize_without_authorization . $product_code . $ipp_period_filter .
				$sub_merchant_list . $qr_type . $custom_route_id . $airline_transaction .
				$airline_passenger_list;
    	$hash_value = hash_hmac('sha256',$params, $secret_key,false);

    	$datasend = 'version='.$version .'&merchant_id='. $merchant_id .'&payment_description='. $payment_description .'&order_id='. $order_id .'&currency='. $currency .'&amount='. $amount .'&customer_email='. $customer_email .'&promotion='.$promotion .'&user_defined_1='. $user_defined_1 .'&user_defined_2='. $user_defined_2 .'&user_defined_3='.$user_defined_3 .'&user_defined_4'. $user_defined_4 .'&user_defined_5'. $user_defined_5 .'&result_url_1='.$result_url_1 .'&result_url_2='. $result_url_2 .'&enable_store_card='. $enable_store_card .'&stored_card_unique_id='.$stored_card_unique_id .'&request_3ds='. $request_3ds .'&recurring='. $recurring .'&order_prefix='.$order_prefix .'&recurring_amount='. $recurring_amount .'&allow_accumulate='. $allow_accumulate .'&max_accumulate_amount='.$max_accumulate_amount .'&recurring_interval='. $recurring_interval .'&recurring_count='.$recurring_count .'&charge_next_date='. $charge_next_date .'&charge_on_date='. $charge_on_date .'&payment_option='.$payment_option .'&ipp_interest_type='. $ipp_interest_type .'&payment_expiry='. $payment_expiry .'&default_lang='.$default_lang .'&statement_descriptor='. $statement_descriptor .'&use_storedcard_only='. $use_storedcard_only .'&tokenize_without_authorization='.$tokenize_without_authorization .'&product_code='. $product_code .'&ipp_period_filter='. $ipp_period_filter .'&sub_merchant_list='.$sub_merchant_list .'&qr_type='. $qr_type .'&custom_route_id='. $custom_route_id .'&airline_transaction='. $airline_transaction .'&airline_passenger_list='.$airline_passenger_list .'&hash_value='.$hash_value;

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

    public function responseback(Request $request)
    {
    	$all = $request->all();
    	//Log::channel('eventy')->info('data '.$all);

	    	$all = '{
	  "version": "8.5",
	  "request_timestamp": "yyyy-MM-dd HH:mm:ss",
	  "merchant_id": "",
	  "order_id": "",
	  "payment_channel": "001",
	  "payment_status": "000",
	  "channel_response_code": "00",
	  "channel_response_desc": "Success",
	  "approval_code": "",
	  "eci": "",
	  "transaction_datetime": "yyyy-MM-dd HH:mm:ss",
	  "transaction_ref": "",
	  "masked_pan": "",
	  "paid_agent": "",
	  "paid_channel": "",
	  "amount": "000000001500",
	  "currency": "764",
	  "user_defined_1": "",
	  "user_defined_2": "",
	  "user_defined_3": "",
	  "user_defined_4": "",
	  "user_defined_5": "",
	  "browser_info": "",
	  "stored_card_unique_id": "",
	  "backend_invoice": "",
	  "recurring_unique_id": "",
	  "ippPeriod": "",
	  "ippInterestType": "",
	  "ippInterestRate": "",
	  "ippMerchantAbsorbRate": "",
	  "payment_scheme": "",
	  "process_by": "",
	  "sub_merchant_list": "",
	  "hash_value": ""
	  
	}';

		 $endjs = json_decode($all);
		 if($endjs->payment_status=="0000" && $endjs->channel_response_code=="00"){
		 	echo "successful";
		 	//  //=============== call create server with package ==============//
    //             $urlcre = env('URL_CREATESERV');
    //             $data = array(
    //             		'userid' => '',
    //             		'start_date' => '',
    //             		'end_date' => '',
    //             		'' => ''
    //             	);

    //            	$curl = curl_init();

				// curl_setopt_array($curl, array(
				//   CURLOPT_URL => $urlcre,
				//   CURLOPT_RETURNTRANSFER => true,
				//   CURLOPT_ENCODING => '',
				//   CURLOPT_MAXREDIRS => 10,
				//   CURLOPT_TIMEOUT => 0,
				//   CURLOPT_FOLLOWLOCATION => true,
				//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				//   CURLOPT_CUSTOMREQUEST => 'POST',
				//   CURLOPT_POSTFIELDS => $data,
				// ));

				// $response = curl_exec($curl);

    //             curl_close($curl);

		 }else{

		 	echo "false";

		 }

    }
}

 