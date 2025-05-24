<?php

namespace App\Filament\Resources\DossierMedicalResource\Pages;

use App\Filament\Resources\DossierMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDossierMedical extends CreateRecord
{
    protected static string $resource = DossierMedicalResource::class;
    protected function authorizeAccess(): void
{
    abort(403);
}
}
