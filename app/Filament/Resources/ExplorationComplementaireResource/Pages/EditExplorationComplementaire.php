<?php

namespace App\Filament\Resources\ExplorationComplementaireResource\Pages;

use App\Filament\Resources\ExplorationComplementaireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExplorationComplementaire extends EditRecord
{
    protected static string $resource = ExplorationComplementaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
