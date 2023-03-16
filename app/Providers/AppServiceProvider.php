<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// PasswordRuleモジュールの使用
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // defaultsルール：8文字以上かつ大小文字１つずつ
        Password::defaults(function () {
            return Password::min(8)->mixedCase()
                                ->uncompromised();
        });

    }
}
