<?php

namespace App\Filament\Resources\MedecinResource\Pages;

use App\Filament\Resources\MedecinResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMedecin extends ViewRecord
{
    protected static string $resource = MedecinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
