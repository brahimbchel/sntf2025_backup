<?php

namespace App\Filament\Resources\RubriqueResource\Pages;

use App\Filament\Resources\RubriqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRubrique extends ViewRecord
{
    protected static string $resource = RubriqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
