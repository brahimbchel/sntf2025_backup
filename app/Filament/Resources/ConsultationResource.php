<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Models\Consultation;
use App\Models\Medecin;
use App\Models\Secteur;
use App\Models\Departement;
use App\Notifications\ConsultationDeletedNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function getNavigationGroup(): ?string
{
    return 'Medical Management';
}

public static function getNavigationSort(): ?int
{
    return 2;
}

public static function canCreate(): bool
{
    return auth()->user()?->isAdmin();
}

public static function canEdit(Model $record): bool
{
    return auth()->user()?->isAdmin() || auth()->user()?->isMedecin();
}

public static function canDelete(Model $record): bool
{
    return auth()->user()?->isAdmin();
}

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();
    $user = auth()->user();

    if ($user?->isAdmin()) {
        return $query; // Les admins voient toutes les consultations
    }

    if ($user?->isMedecin()) {
        return $query->where('medecin_id', $user->medecin->id); // Médecins voient uniquement leurs consultations
    }

    if ($user?->isEmploye()) {
        return $query->where('dossier_id', $user->employe->dossier_medicals->id ?? 0); // Employés voient leurs propres consultations
    }

    return $query; // Par défaut, aucune restriction
}

    public static function form(Form $form): Form
{
    return $form->schema([
        Select::make('dossier_id')
            ->label('Employé')
            ->disabled(fn ($record) => $record && auth()->user()?->isAdmin())
            ->options(
                \App\Models\DossierMedical::with('employe')
                    ->get()
                    ->filter(fn ($dossier) => $dossier->employe)
                    ->mapWithKeys(fn ($dossier) => [
                        $dossier->id => $dossier->employe->nom . ' ' . $dossier->employe->prenom . '     ' . $dossier->employe->matricule
                    ])
            )
            ->searchable()
            ->preload()
            ->required(),

       Select::make('medecin_id')
    ->label('Médecin')
    ->disabled(fn ($record) => $record && auth()->user()?->isAdmin())
    ->options(function () {
    return Medecin::with('specialite', 'centre_medical')->get()->mapWithKeys(function ($medecin) {
        $specialite = $medecin->specialite->nom ?? 'Spécialité non définie';
        $centreMedical = $medecin->centre_medical->nom ?? 'Aucun CMS';
        return [$medecin->id => "{$medecin->nom} {$medecin->prenom} ({$specialite}, CMS: {$centreMedical})"];
    });
    })
    ->searchable()
    ->preload()
    ->required(),

        Select::make('type')
            ->label('Type de consultation')
            ->options([
                'Admission' => 'Admission',
                'Périodique' => 'Périodique',
                'Spontané' => 'Spontané',
                'Reprise' => 'Reprise',
                'Contrôle' => 'Contrôle',
                'AccidentDeTravail' => 'Accident de Travail',
                'ContreVisite' => 'Contre Visite',
                'Réintégration' => 'Réintégration',
            ])
            ->required()
            ->disabled(function ($state, $record) {
                $user = auth()->user();
                return
                    ($user?->isAdmin() && $record && $record->date_consultation < today()) || // Admins can't edit if date passed
                    $user?->isMedecin(); // Médecins ne peuvent jamais modifier ce champ
            }),

            Forms\Components\DatePicker::make('date_consultation')
                ->displayFormat('d/m/Y')
                ->label('Date de Rendez-Vous')
                ->minDate(now()->addDay()->startOfDay())
                ->disabled(function ($record) {
                    $user = auth()->user();
                    return
                        ($user?->isAdmin() && $record && $record->date_consultation < today()) || // Admins can't edit if date passed
                        ($record && $user?->isMedecin()); // Médecins ne peuvent pas modifier si c’est une édition

                    }),

        Select::make('aptitude')
            ->label('Aptitude')
            ->options([
                'apte' => 'Apte',
                'apte avec reserve' => 'Apte avec réserve',
                'inapte' => 'Inapte',
                'inapte définitif' => 'Inapte définitif',
            ])
            ->disabled(fn () => auth()->user()?->isAdmin()),
        Forms\Components\TextInput::make('note')
        ->label('Note')
        ->disabled(fn () => auth()->user()?->isAdmin()),

         ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('dossier_medical.employe.nom')
                ->label('Nom Employé')
                ->sortable()
                ->visible(fn () => !auth()->user()?->isEmploye())
                ->searchable(),
            Tables\Columns\TextColumn::make('dossier_medical.employe.prenom')
                ->label('Prénom Employé')
                ->sortable()
                ->visible(fn () => !auth()->user()?->isEmploye())
                ->searchable(),
            Tables\Columns\TextColumn::make('medecin.nom')
                ->label('Nom Médecin')
                ->sortable()
                ->searchable()
                ->visible(fn () => !auth()->user()?->isMedecin()),

            Tables\Columns\TextColumn::make('medecin.prenom')
                ->label('Prénom Médecin')
                ->sortable()
                ->searchable()
                ->visible(fn () => !auth()->user()?->isMedecin()),

            Tables\Columns\TextColumn::make('medecin.specialite.nom')
                ->label('Spécialité')
                ->sortable()
                ->searchable()
                ->visible(fn () => !auth()->user()?->isMedecin()),

            BadgeColumn::make('type')
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

            BadgeColumn::make('aptitude')
                ->visible(fn () => auth()->user()?->isAdmin())
                ->label('Aptitude')
                ->colors([
                    'success' => 'apte',
                    'danger' => 'inapte',
                    'warning' => 'inapte définitif',
                    'gray' => 'apte avec reserve',
                ]),

            Tables\Columns\TextColumn::make('date_consultation')
                ->label('Date')
                ->date()
                ->sortable(),
                ])
            
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->filters([
                Tables\Filters\SelectFilter::make('time_period')
                    ->label('Période')
                    ->options([
                        'today' => 'Aujourd\'hui',
                        'upcoming' => 'Rendez-vous à venir',
                        'past' => 'Consultations passées',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!isset($data['value'])) {
                            return $query;
                        }
                    
                        return match ($data['value']) {
                            'today' => $query->whereDate('date_consultation', today()),
                            'upcoming' => $query->whereDate('date_consultation', '>', today()),
                            'past' => $query->whereDate('date_consultation', '<', today()),
                            default => $query,
                        };
                    }),
                
                SelectFilter::make('departement')
                    ->label('Département')
                    ->options(fn () => Departement::query()
                        ->select('nom')
                        ->distinct()
                        ->groupBy('nom')
                        ->pluck('nom', 'nom') // Utilise le nom comme clé et valeur
                        ->toArray()
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!isset($data['value'])) {
                            return $query;
                        }

                        return $query->whereHas('dossier_medical', function ($q) use ($data) {
                            $q->whereHas('employe', function ($q2) use ($data) {
                                $q2->whereHas('departement', function ($q3) use ($data) {
                                    $q3->where('nom', $data['value']);
                                });
                            });
                        });
                    })->visible(fn () => !auth()->user()?->isEmploye()),
                
                SelectFilter::make('secteur')
                    ->label('Secteur')
                    ->options(fn () => Secteur::all()->pluck('nom', 'id')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (!isset($data['value'])) {
                            return $query;
                        }
                    
                        return $query->whereHas('dossier_medical', function ($q) use ($data) {
                            $q->whereHas('employe', function ($q2) use ($data) {
                                $q2->whereHas('departement', function ($q3) use ($data) {
                                    $q3->whereHas('secteur', function ($q4) use ($data) {
                                        $q4->where('id', $data['value']);
                                    });
                                });
                            });
                        });
                    })->visible(fn () => !auth()->user()?->isEmploye()),
                
                Filter::make('created_between')
    ->form([
        DatePicker::make('from')
            ->label('De')
            ->native(false)
            ->displayFormat('d/m/Y')
            ->prefixIcon('heroicon-o-calendar-days')
            ->placeholder('Début'),

        DatePicker::make('until')
            ->label('À')
            ->native(false)
            ->displayFormat('d/m/Y')
            ->prefixIcon('heroicon-o-calendar-days')
            ->placeholder('Fin'),
    ])
    ->columns(2) 
    ->query(function (Builder $query, array $data): Builder {
        return $query
            ->when($data['from'] ?? null, fn ($q, $date) => $q->whereDate('date_consultation', '>=', $date))
            ->when($data['until'] ?? null, fn ($q, $date) => $q->whereDate('date_consultation', '<=', $date));
    }),
            ])

            ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make()
                ->visible(fn () => auth()->user()?->isAdmin()),
            Tables\Actions\DeleteAction::make()
                ->before(function (Consultation $record) {
                    // Get the employee associated with the consultation
                    $employeUser = $record->dossier_medical->employe->user;

                    $employeUser ->notify(new ConsultationDeletedNotification(
                            $record
                    ));
                }),
        ])
            ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()
                ->before(function ($records) {
                    foreach ($records as $record) {
                        $employeUser = $record->dossier_medical->employe->user;

                        $employeUser ->notify(new ConsultationDeletedNotification(
                                $record
                        ));
                    }
                }),
        ])
            ;

    }

   

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConsultations::route('/'),
            'create' => Pages\CreateConsultation::route('/create'),
            'view' => Pages\ViewConsultation::route('/{record}'),
            'edit' => Pages\EditConsultation::route('/{record}/edit'),
        ];
    }
//     public static function getRelations(): array
// {
//     return [
//         RelationManagers\OrdonnanceRelationManager::class,
//         RelationManagers\ExplorationComplementaireRelationManager::class,
//         RelationManagers\ExplorationFonctionnelleRelationManager::class,
//         RelationManagers\AppRelationManager::class,
//     ];
// }

}
