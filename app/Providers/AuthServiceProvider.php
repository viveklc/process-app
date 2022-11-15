<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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

        //* Spatie - Role/Permission - Implicitly grant "admin" role all permissions
        //* This works in the app by using gate-related functions like auth()->user->can() and @can()

        // #TODO #LCNOTE enable the code below
        /*
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
        */
    }
}
