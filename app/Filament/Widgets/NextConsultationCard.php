<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Consultation;
use Carbon\Carbon;

class NextConsultationCard extends BaseWidget
{

        protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $user = auth()->user();
        $dossierId = optional($user->employe->dossier_medicals)->id;

        $nextConsultation = null;
        $daysRemaining = null;

        if ($dossierId) {
            $nextConsultation = Consultation::where('dossier_id', $dossierId)
                ->whereDate('date_consultation', '>=', now())
                ->orderBy('date_consultation')
                ->first();

            if ($nextConsultation) {
                $daysRemaining = Carbon::now()->diffInDays($nextConsultation->date_consultation);
            }
        }

        return [
            Card::make('Prochaine consultation', $nextConsultation ? $nextConsultation->date_consultation->format('d/m/Y') : 'Aucune consultation prévue')
                ->description($nextConsultation ? "Il reste {$daysRemaining} jour(s)." : '')
                ->color($nextConsultation ? 'primary' : 'secondary'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->isEmploye();
    }
}