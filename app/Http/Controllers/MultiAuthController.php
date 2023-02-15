<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MultiAuthController extends Controller
{
    // Login用ページの表示
    public function showLoginForm() {
        return view('multi_auth.login');
    }

    // Login関数（引数:$request)
    public function login(Request $request) {

        // 認証はemail,Password
        $credentials = $request->only(['email', 'password']);
        $guard = $request->guard;

        // ログインしたら各ページリダイレクト
        if(\Auth::guard($guard)->attempt($credentials)) {
            return redirect($guard .'/dashboard');
        }

        // 認証の失敗
        return back()->withErrors([
            'auth' => ['認証に失敗しました']
        ]);
    }
}
