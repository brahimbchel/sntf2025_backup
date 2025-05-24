<?php

namespace App\Filament\Resources\DossierMedicalResource\Pages;

use App\Filament\Resources\DossierMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDossierMedicals extends ListRecords
{
    protected static string $resource = DossierMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
