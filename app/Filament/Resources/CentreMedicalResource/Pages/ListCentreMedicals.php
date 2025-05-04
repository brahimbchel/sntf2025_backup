<?php

namespace App\Filament\Resources\CentreMedicalResource\Pages;

use App\Filament\Resources\CentreMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCentreMedicals extends ListRecords
{
    protected static string $resource = CentreMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
