<?php

namespace App\Filament\Resources\CentreMedicalResource\Pages;

use App\Filament\Resources\CentreMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCentreMedical extends ViewRecord
{
    protected static string $resource = CentreMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
