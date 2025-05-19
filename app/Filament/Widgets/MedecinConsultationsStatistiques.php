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
        return Auth::check() && Auth::user()->hasRole('medecin');
    }

    protected static ?int $sort = 10;

    protected function getCards(): array
    {
        $medecinId = Auth::user()?->medecin?->id;

        if (!$medecinId) {
            return [];
        }

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(); // Monday
        $endOfWeek = Carbon::now()->endOfWeek();     // Sunday

        $todayCount = Consultation::where('medecin_id', $medecinId)
            ->whereDate('date_consultation', $today)
            ->count();

        $weekCount = Consultation::where('medecin_id', $medecinId)
            ->whereBetween('date_consultation', [$startOfWeek, $endOfWeek])
            ->count();

        return [
            Card::make("Mes consultations aujourd'hui", $todayCount)
                ->description('Planifiées pour le ' . $today->format('d/m/Y'))
                ->color('success'),

            Card::make("Mes consultations cette semaine", $weekCount)
                ->description('Du ' . $startOfWeek->format('d/m') . ' au ' . $endOfWeek->format('d/m'))
                ->color('info'),
        ];
    }
}
