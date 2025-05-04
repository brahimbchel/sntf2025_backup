<?php

namespace App\Filament\Resources\ExplorationFonctionnelleResource\Pages;

use App\Filament\Resources\ExplorationFonctionnelleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExplorationFonctionnelle extends ViewRecord
{
    protected static string $resource = ExplorationFonctionnelleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
