<?php

namespace App\Filament\Resources\OrdonnanceMedicamentResource\Pages;

use App\Filament\Resources\OrdonnanceMedicamentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrdonnanceMedicament extends EditRecord
{
    protected static string $resource = OrdonnanceMedicamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
