<?php
// app/Filament/Widgets/ConsultationChart.php
namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConsultationChart extends LineChartWidget
{
    protected static ?string $heading = 'Consultations par mois';

    protected static ?int $sort = 10;
    
    // public static function canView(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

    public static function canView(): bool
{
    return auth()->user()?->isAdmin();
}


    protected function getData(): array
    { 
        $data = Consultation::selectRaw('MONTH(date_consultation) as month, COUNT(*) as total')
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
                    'label' => 'rendez-vous planifié',
                    'data' => $dataset,
                    'borderColor' => '#1082f6',
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
