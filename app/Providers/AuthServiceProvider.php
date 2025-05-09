<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    public function boot(): void
    {
        // This lets any logged-in user access Filament
        Gate::define('access-filament', function ($user) {
            return true;
        });

        // Optional: restrict to only users with a specific role
        // Gate::define('access-filament', fn ($user) => $user->hasRole('admin'));
    }
}
