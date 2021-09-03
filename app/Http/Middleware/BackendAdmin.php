<?php

namespace App\Http\Middleware;

use Closure;
#use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class BackendAdmin extends Middleware
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if( $this->auth->guest() ) {
            return redirect('/login');
        }
        else if($this->auth->user()->typeUser !='' and $this->auth->user()->groupType !=0 ) {
            $request->session()->put('auth_fail', 'Invalid access.');
            $this->auth->logout();
            return redirect('/login');
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}