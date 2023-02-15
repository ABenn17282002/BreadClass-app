<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
// Stringメソッドの使用（指定文字列を使用するため）
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            $uri = $request->path();

            // URIが以下2つから始まる場合,mutli_loginページ返す
            if(Str::startsWith($uri, ['administrators/', 'teachers/'])) {
                return 'multi_login';
            }

            return route('login');
        }
    }
}
