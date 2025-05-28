<?php
// app/Filament/Widgets/TopMedecins.php
namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\Medecin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TopMedecins extends BaseWidget
{
    // public static function canView(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

        public static function canView(): bool
{
    return auth()->user()?->isAdmin();
}


    protected static ?int $sort = 5;

    protected function getTableQuery(): Builder
    {
        return Medecin::withCount('consultations')
            ->orderByDesc('consultations_count')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nom')->label('Nom'),
            Tables\Columns\TextColumn::make('prenom')->label('Prénom'),
            Tables\Columns\TextColumn::make('consultations_count')->label('Consultations'),
        ];
    }
}
