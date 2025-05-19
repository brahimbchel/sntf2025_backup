<?php 
// app/Filament/Widgets/MedecinsBySpecialiteChart.php
namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use App\Models\Medecin;
use App\Models\Specialite;
use Illuminate\Support\Facades\Auth;

class MedecinsBySpecialiteChart extends PieChartWidget
{
    protected static ?string $heading = 'Médecins par spécialité';
    protected static ?string $maxHeight = '800px';

    public static function canView(): bool
    {
        return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    }

    protected static ?int $sort = 10;

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
