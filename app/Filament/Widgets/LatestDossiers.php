<?php 
// app/Filament/Widgets/LatestDossiers.php
namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\DossierMedical;
use Illuminate\Database\Eloquent\Builder;

class LatestDossiers extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return DossierMedical::latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('employe->nom')->label('Nom'),
            Tables\Columns\TextColumn::make('created_at')->label('Créé le')->date(),
        ];
    }
}
