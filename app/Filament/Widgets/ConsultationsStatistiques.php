<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConsultationsStatistiques extends BaseWidget
{
    // public static function canView(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

    public static function canView(): bool
{
    return auth()->user()?->isAdmin();
}


    protected static ?int $sort = 2;

    protected function getCards(): array
    {
        $aujourdhui = Carbon::today();
        $debutSemaine = Carbon::now()->startOfWeek(); // lundi
        $finSemaine = Carbon::now()->endOfWeek();     // dimanche

        $consultationsAujourdhui = Consultation::whereDate('date_consultation', $aujourdhui)->count();
        $consultationsSemaine = Consultation::whereBetween('date_consultation', [$debutSemaine, $finSemaine])->count();

        return [
            Card::make('Consultations aujourd\'hui', $consultationsAujourdhui)
                ->description('Planifiées pour le ' . $aujourdhui->format('d/m/Y'))
                ->color('success'),

            Card::make('Consultations cette semaine', $consultationsSemaine)
                ->description('Du ' . $debutSemaine->format('d/m') . ' au ' . $finSemaine->format('d/m'))
                ->color('info'),
        ];
    }
}
