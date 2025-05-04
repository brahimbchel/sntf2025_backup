<?php

namespace App\Filament\Resources\AppareilResource\Pages;

use App\Filament\Resources\AppareilResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAppareil extends ViewRecord
{
    protected static string $resource = AppareilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
