<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class AdminLatestConsultationsWidget extends BaseWidget
{
    protected static ?string $heading = 'Dernières consultations';

    protected static ?int $sort = 4;

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin();
    }

    protected function getTableQuery(): Builder
    {
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SATURDAY);
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::FRIDAY);

        return Consultation::query()
            ->whereBetween('date_consultation', [$startOfLastWeek, now()])
            ->orderByDesc('date_consultation'); // Ordonné par date décroissante
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('dossier_medical.employe.nom')->label('Nom Employé'),
            Tables\Columns\TextColumn::make('dossier_medical.employe.prenom')->label('Prénom Employé'),
            Tables\Columns\TextColumn::make('date_consultation')->label('Date')->date('d/m/Y'),
            Tables\Columns\BadgeColumn::make('aptitude')
                ->label('Aptitude')
                ->colors([
                    'success' => 'apte',
                    'danger' => 'inapte',
                    'warning' => 'inapte définitif',
                    'gray' => 'apte avec reserve',
                ]),
            Tables\Columns\TextColumn::make('note')->label('Orientation/Notes'),
        ];
    }
}