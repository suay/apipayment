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
use Carbon\Carbon;
use App\Model\Reqtoken;

//สร้างคลาสสำหรับ authentication สำหรับ  เพื่อไว้สร้างโทเคนและเช็คความถูกต้อง
class AuthController extends Controller
{
    public function login()
    {
         $credentials = request(['email', 'password']);
         try {
            if (! $token = JWTAuth::attempt($credentials)) {
                $result = array('success'=>false,'errorCode'=>'002','errorMessage'=>'invalid credentials','errorDescription'=>'invalid credentials');
                return response()->json(['result'=>$result,'info'=>''],400);
            }
        } catch (JWTException $e) {
            $result = array('success'=>false,'errorCode'=>'001','errorMessage'=>'could not create token','errorDescription'=>'could not create token');
            return response()->json(['result'=>$result,'info'=>''], 401);
        }

        return $this->responseResult(array('success'=>true),array('token'=>$token));
    }


    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            $mess = $validator->getMessageBag();
            $tag = array("[","]","{","}","\"");
            $newmess = str_replace($tag, "", $mess);
            $explode = explode(":",$newmess);
            return response()->json(['result'=>array('success'=>false,'errorCode'=>'003','errorMessage'=>$newmess,'errorDescription'=>@$explode[1]),'info'=>''], 400);
        }

        $pubkey = $this->genpubkeyString(32);
        $seckey = $this->create_unique($request->get('name'),$request->get('email'));
        
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'pubkey' => $pubkey, //genstirng
            'seckey' => $seckey, //uniqid
            'hash_key' => substr(base64_encode($pubkey),0,-1),
            'hash_pass' => $request->get('password'),

        ]);

        $token = JWTAuth::fromUser($user);
        $user->update(['cuskey' => $token]);
        $data = array(
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'pubkey' => $pubkey, //genstirng
            'seckey' => $seckey, //uniqid
            'cuskey' => $token,
            'create_at' => $user->created_at,
        );
        return response()->json($data);
    }

    

    public function logout()
    {
        if( auth('api')->check() ) {
            auth('api')->logout();
            return response()->json(['result'=> array('success'=>true),'info'=>'']);
        } else {
            return response()->json(['result'=> array('success'=>false,'errorCode'=>'004','errorMessage'=>'could not logout','errorDescription'=>'could not logout'),'info'=>''],401);
        }
           
    }

   

    public function coGetToken (Request $request) {

        $url = env('GBPAY')."v1/tokens";
        $public_key = env('PUBLICKEY').":";
        $encode = base64_encode($public_key);

        if(empty($request->header('Authorization'))){
            return response()->json(['timestamp' => Carbon::now(),'status' => 400,
    'error' => 'Bad Request','exception' => 'could not Authorization.',
    'message' => 'Required request authorization is missing.',
    'path' => '/v1/tokens'], 400);
        }
        if(empty($request->all())){
            return response()->json(['timestamp' => Carbon::now(),'status' => 400,
    'error' => 'Bad Request','exception' => 'could not Authorization.',
    'message' => 'Required request rememberCard is missing.',
    'path' => '/v1/tokens'], 400);
        }


        $auths = explode(" ", substr($request->header('Authorization'), 0,-1) );

        $countuser = User::where('hash_key',$auths[1])->get();
        if(count($countuser)==0){
            $is_valid_key = false;
        }else{
            $is_valid_key = true;
            foreach ($countuser as $setvalue) {
                $credentials['email'] = $setvalue->email;
                $credentials['password'] = $setvalue->hash_pass;
            }

        }
        try {
            if($is_valid_key){
                if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json(['error' => 'Unauthorized'], 401);
                }
                
                $data = json_encode($request->all());
                //curl /v1/tokens
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS =>$data,
                  CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic ".$encode,
                    "Content-Type: application/json"
                  ),
                ));

                $responsedata = curl_exec($curl);
                curl_close($curl);
            
                //save request tokens
                $savelog = Reqtoken::create(['userid' => auth()->user()->id,'req_json' => $data,'resp_json'=>$responsedata]);
                return response()->json(json_decode($responsedata));
                
            }else{
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
    }


    private function genpubkeyString($length = 50){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function create_unique($user,$email) {
        // Read the user agent, IP address, current time, and a random number:

        $data = $user . $email . time() . rand();//$_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] .
                
        $secret_key = 'really secret happypay';//change t
        // Return this value HMAC with sha256
        return base64_encode(hash_hmac('sha256',$data,$secret_key,true));
    }
    
}
