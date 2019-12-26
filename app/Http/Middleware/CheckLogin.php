<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckLogin
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
        $login_name = Session::get('login_name');
        // dd($login_name);
        if (empty($login_name)) {
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
