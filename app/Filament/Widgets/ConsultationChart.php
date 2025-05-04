<?php
// app/Filament/Widgets/ConsultationChart.php
namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Consultation;
use Carbon\Carbon;

class ConsultationChart extends LineChartWidget
{
    protected static ?string $heading = 'Consultations par Mois';

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
                    'label' => 'Consultations',
                    'data' => $dataset,
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
