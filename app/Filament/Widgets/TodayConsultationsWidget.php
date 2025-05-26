<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use App\Models\Consultation;
use Illuminate\Database\Eloquent\Builder;

class TodayConsultationsWidget extends BaseWidget
{
    protected static ?string $heading = 'Consultations d\'aujourd\'hui';

    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->isMedecin();
    }

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        return Consultation::query()
            ->where('medecin_id', $user->medecin->id)
            ->whereDate('date_consultation', today());
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('dossier_medical.employe.nom')
                ->label('Nom Employé')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('dossier_medical.employe.prenom')
                ->label('Prénom Employé')
                ->sortable()
                ->searchable(),
            Tables\Columns\BadgeColumn::make('type')
                ->label('Type')
                ->colors([
                    'primary' => 'Admission',
                    'success' => 'Périodique',
                    'info' => 'Spontané',
                    'warning' => 'Reprise',
                    'secondary' => 'Contrôle',
                    'danger' => 'AccidentDeTravail',
                    'gray' => 'ContreVisite',
                    'indigo' => 'Réintégration',
                ]),
            
        ];
    }
}