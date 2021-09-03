<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;
use Redirect;

class UserController extends Controller
{
  
    public function __construct () {
        $this->middleware('backend-admin'); 
        view()->share('active_menu', 'user');
    }

    public function index(Request $request)
    {
        
        $user= User::orderBy('created_at', 'DESC')->paginate(50);
        $user->setPath('user/url');
        if (!$request->ajax()) {
            return view('user.list')->with(compact('user'));
        } else {
            return view('user.list-element')->with(compact('user'));
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            
            return redirect('user');
        } else {
            $user = new User;
            return view('user.add')->with(compact('user'));
        }
    }

    public function view(Request $request)
    {
       
        $user = User::find($request->get('id'));
        return view('user.view')->with(compact('user'));

    }

    public function edit($id = null, Request $request)
    {
        if ($request->isMethod('post')) {
            //edit
            return redirect('user');
        } else {
            
            $user = User::find($id);
            return view('user.edit')->with(compact('user'));
        }
    }
}