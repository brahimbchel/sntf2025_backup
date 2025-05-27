<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Filament\Resources\ConsultationResource\RelationManagers;
use App\Models\Consultation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Medecin;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\BaseResource;
use App\Models\Departement;
use App\Models\Secteur;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
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

    if (auth()->user()?->isAdmin()) {
        return $query; // Agents and admins see all consultations
    }

    if (auth()->user()?->isMedecin()) {
        return $query->where('medecin_id', $user->medecin->id);
    }

    if (auth()->user()?->isEmploye()) {
        return $query->where('dossier_id', $user->employe->dossier_medicals->id ?? 0);
    }

    return $query; // Fallback for other roles
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        
                Select::make('dossier_id')
                    ->label('Employé')
                    ->disabled(fn ($record) => $record)
                    // ->disabled(fn ($record) => $record && auth()->user()?->isAdmin())
                    ->options(
                        \App\Models\DossierMedical::with('employe') // Charger les employés associés aux dossiers
                            ->get()
                            ->filter(fn ($dossier) => $dossier->employe)
                            ->mapWithKeys(fn ($dossier) => [
                                $dossier->id => $dossier->employe->nom . ' ' . $dossier->employe->prenom
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('medecin_id')
                    ->label('Médecin')
                    ->disabled(fn ($record) => $record)
                    // ->disabled(fn ($record) => $record && auth()->user()?->isAdmin())
                    ->options(function () {
                        return Medecin::with('specialite')->get()->mapWithKeys(function ($medecin) {
                            // $specialite = $medecin->specialite->nom ?? 'Aucune spécialité';
                            // return [$medecin->id => $medecin->nom . ' ' . $medecin->prenom . ' (' . $specialite . ')'];
                            return [$medecin->id => $medecin->nom . ' ' . $medecin->prenom ];
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
                    ->disabled(function ($state, $record) {
                        $user = auth()->user();
                        return
                            ($user?->isAdmin() && $record && $record->date_consultation < today()) || // Admins can't edit if date passed
                            $user?->isMedecin(); // Médecins ne peuvent jamais modifier ce champ
                    })
                    ->required(),

                Forms\Components\DatePicker::make('date_consultation')
                    ->displayFormat('d/m/Y')
                    ->label('Date de Rendez-Vous')
                    ->disabled(function ($record) {
                        $user = auth()->user();
                        return
                            ($user?->isAdmin() && $record && $record->date_consultation < today()) || // Admins can't edit if date passed
                            ($record && $user?->isMedecin()); // Médecins ne peuvent pas modifier si c’est une édition
                    })
                    ->minDate(now()->addDay()->startOfDay()),

                Select::make('aptitude')
                    ->label('Aptitude')
                    ->disabled(fn () => auth()->user()?->isAdmin())
                    ->options([
                        'apte' => 'Apte',
                        'apte avec reserve' => 'apte avec reserve',
                        'inapte' => 'Inapte',
                        'inapte définitif' => 'inapte définitif'
                    ]),

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
                ->visible(fn () => !auth()->user()?->isMedecin())
                ->searchable(),

            Tables\Columns\TextColumn::make('medecin.prenom')
                ->label('Prénom Médecin')
                ->sortable()
                ->visible(fn () => !auth()->user()?->isMedecin())
                ->searchable(),

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
                Tables\Filters\SelectFilter::make('departement')
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
                Tables\Filters\SelectFilter::make('secteur')
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

                Filter::make('created_between')->form([
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
                
            ])
             ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);

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
    public static function getRelations(): array
{
    return [
        RelationManagers\OrdonnanceRelationManager::class,
        RelationManagers\ExplorationComplementaireRelationManager::class,
        RelationManagers\ExplorationFonctionnelleRelationManager::class,
        RelationManagers\AppRelationManager::class,
    ];
}

}
