<?php

namespace App\Filament\Resources\DossierMedicalResource\Pages;

use App\Filament\Resources\DossierMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDossierMedical extends ViewRecord
{
    protected static string $resource = DossierMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
