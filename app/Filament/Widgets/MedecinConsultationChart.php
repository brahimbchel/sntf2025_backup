<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedecinConsultationChart extends LineChartWidget
{
    protected static ?string $heading = 'Mes consultations par mois';

    protected static ?int $sort = 10;
    
    // public static function canView(): bool
    // {
    //     return Auth::check() && Auth::user()->hasRole('medecin');
    // }
    
    public static function canView(): bool
{
    return auth()->user()?->isMedecin();
}

    protected function getData(): array
    {
        $medecinId = Auth::user()?->medecin?->id;

        if (!$medecinId) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $data = Consultation::where('medecin_id', $medecinId)
            ->selectRaw('MONTH(date_consultation) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $labels = [];
        $dataset = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $dataset[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Mes consultations',
                    'data' => $dataset,
                    'borderColor' => '#00b894',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                        'beginAtZero' => true,
                    ],
                ],
            ],
        ];
    }
}
