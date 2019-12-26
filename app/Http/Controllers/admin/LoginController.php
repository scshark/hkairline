<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;


class LoginController extends Controller
{
    public function login (Request $request) {

        if ($request->isMethod('post')) {
            $account = $request->input('account');
            $password = $request->input('password');
            if ($account == 'super' && $password == 'admin654321') {
                Session::put('login_name', $account);

                return response()->json([
                    'errcode' => 0,
                    'errmsg' => '登录成功',
                    'url' => route('admin.index.index')
                ]);
            } else {
                return response()->json([
                    'errcode' => 1,
                    'errmsg' => '账号密码错误'
                ]);
            }
        } else {
            // dd(config('view.admin_assets'));
            return view('admin.login.login');
        }
    }

    public function loginout()
    {
        Session::put('login_name', NULL);
        return redirect('/admin/login');
    }
}
