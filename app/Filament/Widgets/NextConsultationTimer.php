<?php 

namespace App\Filament\Widgets;

use App\Models\Consultation;
use Filament\Widgets\Widget;
use Carbon\Carbon;

class NextConsultationTimer extends Widget
{
    protected static string $view = 'filament.widgets.next-consultation-timer';

    protected static ?int $sort = 10;

        public static function canView(): bool
{
    return auth()->user()?->isEmploye();
}


    protected function getViewData(): array
    {

        
        $user = auth()->user();

        if (!auth()->user()?->isEmploye()) {
            return ['nextConsultation' => null];
        }

        $dossierId = optional($user->employe->dossier_medicals)->id;

        if (!$dossierId) {
            return ['nextConsultation' => null];
        }

        $nextConsultation = Consultation::where('dossier_id', $dossierId)
            ->whereDate('date_consultation', '>=', now())
            ->orderBy('date_consultation')
            ->first();

        return ['nextConsultation' => $nextConsultation];
    }
}
