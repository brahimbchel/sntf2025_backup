<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Consultation;
use Carbon\Carbon;

class ConsultationsStatistiques extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->isAdmin();
    }

    protected static ?int $sort = 2;

    protected function getCards(): array
    {
        $today = Carbon::today();

        // Semaine actuelle : samedi (dernier ou aujourd'hui) -> vendredi prochain
        $startOfWeek = Carbon::now()->copy()->startOfWeek(Carbon::SATURDAY);
        $endOfWeek = $startOfWeek->copy()->addDays(6);

        // Semaine précédente : samedi précédent -> vendredi précédent
        $startOfLastWeek = $startOfWeek->copy()->subWeek();
        $endOfLastWeek = $startOfWeek->copy()->subDay();

        $consultationsToday = Consultation::whereDate('date_consultation', $today)->count();

        $consultationsThisWeek = Consultation::whereBetween('date_consultation', [
            $startOfWeek->toDateString(), $endOfWeek->toDateString()
        ])->count();

        $consultationsLastWeek = Consultation::whereBetween('date_consultation', [
            $startOfLastWeek->toDateString(), $endOfLastWeek->toDateString()
        ])->count();

        return [
            Card::make("Consultations aujourd'hui", $consultationsToday)
                ->description('Planifiées le ' . $today->format('d/m/Y'))
                ->color('success'),

            Card::make('Consultations cette semaine', $consultationsThisWeek)
                ->description('Du ' . $startOfWeek->format('d/m') . ' au ' . $endOfWeek->format('d/m'))
                ->color('info'),

            Card::make('Consultations la semaine dernière', $consultationsLastWeek)
                ->description('Du ' . $startOfLastWeek->format('d/m') . ' au ' . $endOfLastWeek->format('d/m'))
                ->color('warning'),
        ];
    }
}
