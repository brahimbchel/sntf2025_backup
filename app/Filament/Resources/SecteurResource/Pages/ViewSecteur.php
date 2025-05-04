<?php

namespace App\Filament\Resources\SecteurResource\Pages;

use App\Filament\Resources\SecteurResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSecteur extends ViewRecord
{
    protected static string $resource = SecteurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
