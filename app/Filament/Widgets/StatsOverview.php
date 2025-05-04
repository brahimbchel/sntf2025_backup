<?php 
// app/Filament/Widgets/StatsOverview.php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Employe;
use App\Models\Medecin;
use App\Models\Consultation;
use App\Models\DossierMedical;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Employés', Employe::count())->color('success'),
            Card::make('Médecins', Medecin::count())->color('primary'),
            Card::make('Consultations', Consultation::count())->color('warning'),
            Card::make('Dossiers Médicaux', DossierMedical::count())->color('danger'),
        ];
    }
}
