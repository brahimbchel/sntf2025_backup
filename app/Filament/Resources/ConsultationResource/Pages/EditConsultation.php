<?php

namespace App\Filament\Resources\ConsultationResource\Pages;

use App\Filament\Resources\ConsultationResource;
use App\Notifications\ConsultationUpdatedNotification;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsultation extends EditRecord
{
    protected static string $resource = ConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

     protected function beforeSave(): void
     {
        if ($this->record->isDirty('date_consultation')){
            $oldDate = $this->record->getOriginal('date_consultation');
            $newDate = $this->record->date_consultation;

            $employeUser = $this->record->dossier_medical->employe->user;

            if ($employeUser) {
                $employeUser->notify(new ConsultationUpdatedNotification(
                    $this->record, 
                    $oldDate, 
                    $newDate
                ));
            }

        }
     }
}
