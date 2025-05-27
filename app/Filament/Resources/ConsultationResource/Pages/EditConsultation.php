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
            Actions\ViewAction::make()
                ->label('Voir')
                ->icon('heroicon-o-eye'),
            Actions\DeleteAction::make()
                ->label('Supprimer')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->modalHeading('Supprimer la consultation')
                ->modalDescription('Êtes-vous sûr de vouloir supprimer cette consultation ? Cette action est irréversible.')
                ->modalSubmitActionLabel('Oui, supprimer'),
        ];
    }

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }

    protected function beforeSave(): void
    {
        $oldDate = $this->record->getOriginal('date_consultation');
        $newDate = $this->record->date_consultation;
        
        if ($oldDate != $newDate) {
            $this->record->dossier_medical->employe->user->notify(
                new ConsultationUpdatedNotification($this->record, $oldDate, $newDate)
            );
        }
    }
}
