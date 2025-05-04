<?php

namespace App\Filament\Resources\ResultatResource\Pages;

use App\Filament\Resources\ResultatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewResultat extends ViewRecord
{
    protected static string $resource = ResultatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
