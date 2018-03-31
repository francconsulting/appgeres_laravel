<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class is_Check
{
    protected  $auth;

    /**
     * is_Check constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response =   $next($request);
        if(!$this->auth->check()){
            if($request->ajax()){
                $this->auth->logout();
                return response()->json(['checkout' => true], 401);
            } else {
                return redirect()->guest('login');
            }
        }
        return $response;
    }


}
