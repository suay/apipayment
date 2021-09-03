<?php

namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

    class JwtMiddleware extends BaseMiddleware
    {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['status' => 'Token is Invalid']);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['status' => 'Token is Expired']);
                }else{
                   return response()->json(['status' => 'Authorization Token not found']);
                }
            }
            return $next($request);
        }
        // public function handle($request, Closure $next)
        // {
        //     try {
        //         $user = JWTAuth::toUser($request->header('token'));

        //     } catch (JWTException $e) {
        //         if ($e instanceof TokenExpiredException) {
        //             return response()->json([
        //                 'error' => 'token_expired',
        //                 'code' => $e->getStatusCode()
        //             ], $e->getStatusCode());
        //         } 
        //         else if($e instanceof TokenInvalidException){
        //             return response()->json([
        //                 'error' => "token_invalid",
        //                 'code' => $e->getStatusCode()
        //             ], $e->getStatusCode());
        //         } 
        //         else {
        //             return response()->json([
        //                 'error' => 'Token is required',
        //                 'code' => $e->getStatusCode(),

        //             ], $e->getStatusCode());
        //         }
        //     }

        //     return $next($request);
        // }
    }
