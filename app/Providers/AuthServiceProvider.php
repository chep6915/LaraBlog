<?php

namespace App\Providers;

use App\Classes\Guards\AdminUserGuard;
use Illuminate\Auth\RequestGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        //
        Auth::extend('adminUserGuard', function($app, $name, array $config) {
            return new RequestGuard(function ($request) use ($config) {
                return (new AdminUserGuard())->user($request);
            }, $this->app['request']);
        });
    }
}
