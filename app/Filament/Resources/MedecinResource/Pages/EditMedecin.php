<?php

namespace App\Filament\Resources\MedecinResource\Pages;

use App\Filament\Resources\MedecinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedecin extends EditRecord
{
    protected static string $resource = MedecinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
