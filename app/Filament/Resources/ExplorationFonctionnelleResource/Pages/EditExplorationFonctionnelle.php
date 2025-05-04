<?php

namespace App\Filament\Resources\ExplorationFonctionnelleResource\Pages;

use App\Filament\Resources\ExplorationFonctionnelleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExplorationFonctionnelle extends EditRecord
{
    protected static string $resource = ExplorationFonctionnelleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
