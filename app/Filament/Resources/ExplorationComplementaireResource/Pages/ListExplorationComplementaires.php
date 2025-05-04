<?php

namespace App\Filament\Resources\ExplorationComplementaireResource\Pages;

use App\Filament\Resources\ExplorationComplementaireResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExplorationComplementaires extends ListRecords
{
    protected static string $resource = ExplorationComplementaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
