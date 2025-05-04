<?php

namespace App\Filament\Resources\OrdonnanceMedicamentResource\Pages;

use App\Filament\Resources\OrdonnanceMedicamentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdonnanceMedicaments extends ListRecords
{
    protected static string $resource = OrdonnanceMedicamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
