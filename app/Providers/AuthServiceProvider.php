<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// use BezhanSalleh\FilamentShield\FilamentShieldPlugin;

class AuthServiceProvider extends ServiceProvider
{
    // protected $policies = [
    //     \App\Models\User::class => \App\Policies\UserPolicy::class,
    // ];

    public function boot(): void
    {
        // FilamentShieldPlugin::registerPolicies();

        // This lets any logged-in user access Filament
        // Gate::define('access-filament', function ($user) {
        //     return true;
        // });

        // Gate::define('access-filament', function ($user) {
        //     // Only users with specific roles can access Filament
        //     return $user->hasRole(['Admin', 'Super Admin']);
        // });

        Gate::define('access-filament', fn ($user) => $user->hasAnyRole([
            'Admin',
            'Super Admin',
            'Employe', 'employe',
            'Medecin',
        ]));

        Gate::define('access-filament', fn ($user) => $user->isAdmin() || $user->isMedecin() || $user->isEmploye());

        // Optional: restrict to only users with a specific role
        // Gate::define('access-filament', fn ($user) => $user->hasRole('Super Admin'));
    }
}
