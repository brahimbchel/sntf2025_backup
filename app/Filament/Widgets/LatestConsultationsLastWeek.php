<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\Consultation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LatestConsultationsLastWeek extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->isAdmin();
    }

    protected static ?int $sort = 11;

    protected static ?string $heading = 'Consultations de la semaine passée';

    protected function getTableQuery(): Builder
    {
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SATURDAY);
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::FRIDAY);

       return Consultation::query()
    ->whereBetween('date_consultation', [$startOfLastWeek, $endOfLastWeek])
    ->latest()
    ->with(['dossierMedical.employe'])
    ->limit(5);

    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('dossierMedical.employe.nom')->label('Nom'),
            Tables\Columns\TextColumn::make('dossierMedical.employe.prenom')->label('Prénom'),
            Tables\Columns\TextColumn::make('dossierMedical.employe.matricule')->label('Matricule'),
            Tables\Columns\TextColumn::make('aptitude')->label('Aptitude'),
            Tables\Columns\TextColumn::make('note')->label('Note'),
            Tables\Columns\TextColumn::make('date_consultation')->label('Date')->date('d/m/Y'),
        ];
    }
}