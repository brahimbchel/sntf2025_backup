<?php

namespace App\Filament\Resources\ResultatResource\Pages;

use App\Filament\Resources\ResultatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResultat extends EditRecord
{
    protected static string $resource = ResultatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
