<?php

namespace App\Filament\Resources\ExplorationFonctionnelleResource\Pages;

use App\Filament\Resources\ExplorationFonctionnelleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExplorationFonctionnelles extends ListRecords
{
    protected static string $resource = ExplorationFonctionnelleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
