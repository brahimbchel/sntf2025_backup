<?php
namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\ConsultationChart;
use App\Filament\Widgets\TopMedecins;
use App\Filament\Widgets\LatestDossiers;
use App\Filament\Widgets\MedecinsBySpecialiteChart;
use App\Filament\Widgets\AdminAlerts;
use App\Filament\Widgets\EmployeeDossierBarChart;
use App\Filament\Widgets\MedecinOccupancy;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            ConsultationChart::class,
            MedecinsBySpecialiteChart::class,
            TopMedecins::class,
            LatestDossiers::class,
            EmployeeDossierBarChart::class,
            MedecinOccupancy::class,
        ];
    }
}
