<?php 
// app/Filament/Widgets/MedecinsBySpecialiteChart.php
namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use App\Models\Medecin;
use App\Models\Specialite;

class MedecinsBySpecialiteChart extends PieChartWidget
{
    protected static ?string $heading = 'Médecins par Spécialité';

    protected function getData(): array
    {
        $specialites = Specialite::withCount('medecins')->get();

        return [
            'datasets' => [
                [
                    'data' => $specialites->pluck('medecins_count'),
                    'backgroundColor' => [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#ec4899',
                        '#14b8a6',
                    ],
                ],
            ],
            'labels' => $specialites->pluck('nom'),
        ];
    }
}
