<?php

namespace App\Filament\Resources\ResultatResource\Pages;

use App\Filament\Resources\ResultatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResultat extends CreateRecord
{
    protected static string $resource = ResultatResource::class;

    protected function getRedirectUrl(): string
    {
        // return $this->getResource()::getUrl('view', ['record' => $this->record]);
         return $this->getResource()::getUrl('index');
    }
}
