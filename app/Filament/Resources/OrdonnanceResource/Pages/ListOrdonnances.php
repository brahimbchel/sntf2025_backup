<?php

namespace App\Filament\Resources\OrdonnanceResource\Pages;

use App\Filament\Resources\OrdonnanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdonnances extends ListRecords
{
    protected static string $resource = OrdonnanceResource::class;

    public static function canAccess(array $parameters = []): bool
{
    return auth()->user()?->isAdmin() || auth()->user()?->isMedecin();
}


}
