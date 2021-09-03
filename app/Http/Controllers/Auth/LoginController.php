<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Model\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // public function login(Request $request)
    // {
    //     $this->validate($request, [
    //         'email'           => 'required|max:255|email',
    //         'password'           => 'required|confirmed',
    //     ]);
    //     if (Auth::attempt(['email' => $email, 'password' => $password])) {
    //         // Success
    //         return redirect()->intended('/login');
    //     } else {
    //         // Go back on error (or do what you want)
    //         // return "Wrong Credentials";
    //         return redirect()->back();
          
    //     }
    
    // }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

    protected function sendFailedLoginResponse(Request $request) {
     
        // $request->session()->put('auth_fail', 'Wrong username or password.');
        // return redirect('/login');
        // Load user from database
        $user = User::where($this->username(),$request->get('email'))->first();
        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ( $user &&\Hash::check($request->password, $user->password) == false) {
            $request->session()->put('auth_fail', 'Wrong Password.');
        }
        else{
            $request->session()->put('auth_fail', 'Your account not found. Please contact staff.');
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back();

    }
}