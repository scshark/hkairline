<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccessControlAllowOrigin
{
    /**
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {




        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); //允许的请求类型
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Expose-Headers: *");

        return $next($request);
    }
}
