<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // PASTE KODEMU DI SINI
        Gate::define('is-pelanggan', function (User $user) {
            return $user->role === 'pelanggan';
        });

        Gate::define('is-kitchen', function (User $user) {
            return $user->role === 'kitchen';
        });

        Gate::define('is-kasir', function (User $user) {
            return $user->role === 'kasir';
        });
    }
}