<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// 認証モデルの使用
use Illuminate\Support\Facades\Auth;
// Gateモデルの使用
use Illuminate\Support\Facades\Gate;
// Administrator, Teacherモデルの使用
use app\Models\Administrator;
use App\Models\Teacher;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 管理者
        Gate::define('admin', function(Administrator $administrator){
            return $administrator->role === 1;
        });

    }
}
