<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedecinConsultationsStatistiques extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->isMedecin();
    }

    protected static ?int $sort = 10;

    protected function getCards(): array
    {
        $medecinId = Auth::user()?->medecin?->id;

        if (!$medecinId) {
            return [];
        }

        $today = Carbon::today();

        // Définir le début et la fin de la semaine actuelle (samedi à vendredi)
        $startOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $endOfCurrentWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);

        // Définir la semaine passée (samedi dernier à vendredi dernier)
        $startOfLastWeek = (clone $startOfCurrentWeek)->subWeek();
        $endOfLastWeek = (clone $endOfCurrentWeek)->subWeek();

        // Nombre de consultations aujourd'hui
        $todayCount = Consultation::where('medecin_id', $medecinId)
            ->whereDate('date_consultation', $today)
            ->count();

        // Nombre de consultations cette semaine
        $currentWeekCount = Consultation::where('medecin_id', $medecinId)
            ->whereBetween('date_consultation', [$startOfCurrentWeek, $endOfCurrentWeek])
            ->count();

        // Nombre de consultations la semaine passée
        $lastWeekCount = Consultation::where('medecin_id', $medecinId)
            ->whereBetween('date_consultation', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        return [
            Card::make("Aujourd'hui", $todayCount)
                ->description('Consultations du ' . $today->format('d/m/Y'))
                ->color('success'),

            Card::make("Cette semaine", $currentWeekCount)
                ->description('Du ' . $startOfCurrentWeek->format('d/m') . ' au ' . $endOfCurrentWeek->format('d/m'))
                ->color('info'),

            Card::make("Semaine passée", $lastWeekCount)
                ->description('Du ' . $startOfLastWeek->format('d/m') . ' au ' . $endOfLastWeek->format('d/m'))
                ->color('gray'),
        ];
    }
}
