<?php

namespace App\Filament\Resources\DossierMedicalResource\Pages;

use App\Filament\Resources\DossierMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDossierMedical extends EditRecord
{
    protected static string $resource = DossierMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
