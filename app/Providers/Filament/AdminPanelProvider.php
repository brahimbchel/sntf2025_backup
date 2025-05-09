<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;

class AdminPanelProvider extends PanelProvider
{
    // Get the home URL based on the user's role
    public function getHomeUrl(): string
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return route('filament.admin.pages.dashboard');
        } elseif ($user->hasRole('medecin')) {
            return route('filament.admin.pages.dashboard');
        } elseif ($user->hasRole('employe')) {
            return route('filament.admin.pages.dashboard');
        } elseif ($user->hasRole('agent_de_saisie')) {
            return route('filament.admin.pages.dashboard');
        }

        return route('filament.admin.pages.dashboard');
    }

    // Configure the Filament panel
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->homeUrl('/')
            ->authMiddleware([
                Authenticate::class,       // Middleware pour authentifier l'utilisateur
                'verified',                // Vérifier que l'email est confirmé
                'can:access-filament',     // Ajouter un contrôle d'accès spécifique pour Filament
            ])
            ->brandName('SNTF_MED')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Add widgets here if needed
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ]);
    }
}
