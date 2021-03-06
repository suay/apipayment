@extends('layouts.app')
@section('content')


        <div class="form-box" id="login-box">
            <div class="header">RapidTest</div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    // Reveal Login form
                    setTimeout(function() {
                        $(".fade-in-effect").addClass('in');
                    }, 1);
                    // Set Form focus
                    $("form#login .form-group:has(.form-control):first .form-control").focus();
                });
            </script>
            <form action="{{ route('login') }}" method="post" class="fade-in-effect">
                @csrf
                <div class="body bg-gray">
                     @if (session()->has('auth_fail'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->pull('auth_fail') }}
                        </div>
                     @endif
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                        @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember" id="remember" 
                        {{ old('remember') ? 'checked' : '' }}/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">{{ trans('messages.Auth.login') }}</button>  
                    
                    <!-- <p><a href="#">I forgot my password</a></p> -->
                    
                    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
                </div>
            </form>

            <!-- <div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
 
            </div>-->
        </div>


    @endsection