<?php

namespace App\Filament\Resources\OrdonnanceMedicamentResource\Pages;

use App\Filament\Resources\OrdonnanceMedicamentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrdonnanceMedicament extends ViewRecord
{
    protected static string $resource = OrdonnanceMedicamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
