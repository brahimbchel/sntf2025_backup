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
                ->url('https://drive.google.com/file/d/1-0znzR4bm8Vqa1r87NiNGPSMgggq4PQg/view?usp=drivesdk')
                ->color('success'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->isEmploye();
    }
}