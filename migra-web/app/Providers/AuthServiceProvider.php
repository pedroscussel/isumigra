<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Company' => 'App\Policies\CompanyPolicy',
        'App\Container' => 'App\Policies\ContainerPolicy',
        'App\ContainerType' => 'App\Policies\ContainerTypePolicy',
        'App\Device' => 'App\Policies\DevicePolicy',
        'App\ServiceOrder' => 'App\Policies\ServiceOrderPolicy',
        'App\Truck' => 'App\Policies\TruckPolicy',
        'App\User' => 'App\Policies\UserPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('see_menu', function ($user) {
            return !($user->role->slug == 'generator');
        });

        // Administrador principal (root)
        Gate::before(function ($user, $ability) {
            if ($user->hasAllAccess(['admin', 'migra'])) {
                return true;
            }
        });

        // Administrador principal (root)
        Gate::define('root', function ($user) {
            return $user->hasAllAccess(['migra', 'admin']);
        });

        Gate::define('migra', function ($user) {
            return $user->hasAccess(['migra']);
        });

        Gate::define('admin', function ($user) {
            return $user->hasAccess(['admin']);
        });

        Gate::define('migra_manager', function ($user) {
            return $user->hasAllAccess(['manager', 'migra']);
        });

        Gate::define('migra_bussines', function ($user) {
            return $user->hasAllAccess(['bussines', 'migra']);
        });

        Gate::define('migra_operator', function ($user) {
            return $user->hasAllAccess(['operator', 'migra']);
        });



        Gate::define('manager', function ($user) {
            return $user->hasAccess(['manager', 'admin']);
        });

        Gate::define('business', function ($user) {
            return $user->hasAccess(['business', 'admin']);
        });

        Gate::define('operator', function ($user) {
            return $user->hasAccess(['operator', 'admin']);
        });

        Gate::define('users', function ($user) {
            return $user->hasAccess(['manager', 'business', 'operator', 'admin', 'migra']);
        });

        Gate::define('client', function ($user) {
            return $user->hasAccess(['client', 'admin']);
        });

        Gate::define('all', function ($user) {
            return true;
        });
    }
}
