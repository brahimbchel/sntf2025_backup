<?php

namespace App\Filament\Resources\ExplorationComplementaireResource\Pages;

use App\Filament\Resources\ExplorationComplementaireResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExplorationComplementaire extends ViewRecord
{
    protected static string $resource = ExplorationComplementaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
