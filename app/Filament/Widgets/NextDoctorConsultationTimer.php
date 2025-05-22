<?php

namespace App\Filament\Widgets;

use App\Models\Consultation;
use Filament\Widgets\Widget;

class NextDoctorConsultationTimer extends Widget
{
    protected static string $view = 'filament.widgets.next-doctor-consultation-timer';

    protected static ?int $sort = 9;

        public static function canView(): bool
{
    return auth()->user()?->isMedecin();
}


    protected function getViewData(): array
    {
        $user = auth()->user();

        $medecinId = optional($user->medecin)->id;

        if (! $medecinId) {
            return ['nextConsultation' => null];
        }

        $nextConsultation = Consultation::where('medecin_id', $medecinId)
            ->where('date_consultation', '>=', now())
            ->orderBy('date_consultation')
            ->first();

        return ['nextConsultation' => $nextConsultation];
    }
}