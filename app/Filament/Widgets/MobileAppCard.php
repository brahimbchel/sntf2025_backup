<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class MobileAppCard extends BaseWidget
{
        protected static ?int $sort = 1;

    protected function getCards(): array
    {
        return [
            Card::make('Application mobile disponible', 'Notre application mobile est disponible pour simplifier votre expérience.')
                ->description('Télécharger maintenant')
                ->url('https://example.com/download')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->isEmploye();
    }
}