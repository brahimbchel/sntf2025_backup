<?php 
// app/Filament/Widgets/StatsOverview.php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Employe;
use App\Models\Medecin;
use App\Models\Consultation;
use App\Models\DossierMedical;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    // public static function canView(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

        public static function canView(): bool
{
    return auth()->user()?->isAdmin();
}


    protected static ?int $sort = 10;

    protected function getCards(): array
    {
        return [
            Card::make('Employés', Employe::count())->color('success'),
            Card::make('Médecins', Medecin::count())->color('primary'),
            Card::make('Consultations', Consultation::count())->color('warning'),
        ];
    }
}
