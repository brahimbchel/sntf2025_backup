<?php

namespace App\Filament\Resources\SpecialiteResource\Pages;

use App\Filament\Resources\SpecialiteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSpecialite extends ViewRecord
{
    protected static string $resource = SpecialiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
