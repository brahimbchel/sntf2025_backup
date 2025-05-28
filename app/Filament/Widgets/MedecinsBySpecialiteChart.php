<?php 
namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use App\Models\Specialite;

class MedecinsBySpecialiteChart extends PieChartWidget
{
    protected static ?string $heading = 'Médecins par spécialité';
    protected static ?string $maxHeight = '800px';

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin();
    }

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // Utilisation correcte de la relation avec 'specialite_id'
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