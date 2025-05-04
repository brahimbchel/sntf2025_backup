<?php

namespace App\Filament\Resources\CentreMedicalResource\Pages;

use App\Filament\Resources\CentreMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCentreMedical extends EditRecord
{
    protected static string $resource = CentreMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
