<?php
namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets;
// use App\Filament\Widgets\MedecinConsultationChart;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | string | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }
    protected static ?int $sort = 2;
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
            ConsultationsStatistiques::class,
            // MedecinConsultationChart::class,
        ];
    }
}
