<?php

namespace App\Filament\Resources\ConsultationResource\Pages;

use App\Filament\Resources\ConsultationResource;
use App\Models\DossierMedical;
use App\Models\Medecin;
use App\Notifications\EmployeConsultationNotification;
use App\Notifications\MedecinConsultationNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateConsultation extends CreateRecord
{
    protected static string $resource = ConsultationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    // Get models
    $medecin = Medecin::find($data['medecin_id']);
    $dossier = DossierMedical::with('employe')->find($data['dossier_id']);

    // Safety check
    if ($medecin && $dossier && $dossier->employe) {
        $date = now()->format('Y-m-d'); // Or pull this from $data if you have a consultation date field

        // Notify medecin
        $medecin->user->notify(new MedecinConsultationNotification(
            $dossier->employe->nom,
            $date
        ));

        // Notify employe
        $dossier->employe->user->notify(new EmployeConsultationNotification(
            $medecin->nom,
            $date
        ));
    }

    return $data;
}

}
