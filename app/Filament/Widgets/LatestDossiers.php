<?php 
// app/Filament/Widgets/LatestDossiers.php
namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\DossierMedical;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LatestDossiers extends BaseWidget
{

    // public static function canView(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

    public static function canView(): bool
{
    return auth()->user()?->isAdmin();
}


    protected static ?int $sort = 10;

    protected static ?string $heading = 'Derniers dossiers ';

    protected function getTableQuery(): Builder
    {
        return DossierMedical::latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('employe.nom')->label('Nom'),
            Tables\Columns\TextColumn::make('employe.prenom')->label('Prénom'),
            Tables\Columns\TextColumn::make('employe.departement.nom')->label('Département'),
            Tables\Columns\TextColumn::make('created_at')->label('Créé le')->dateTime('d/m/Y')
        ];
    }
}
