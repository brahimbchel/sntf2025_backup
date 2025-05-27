<?php

namespace App\Filament\Resources\DossierMedicalResource\RelationManagers;

use App\Models\Appareil;
use App\Models\Rubrique;
use App\Models\Resultat;
use App\Models\Medicament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ConsultationRelationManager extends RelationManager
{
    protected static string $relationship = 'consultations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('diagnostic')->required()->columnSpanFull()->maxLength(255),

                Select::make('aptitude')
                    ->label('Aptitude')
                    ->options([
                        'apte' => 'Apte',
                        'apte avec reserve' => 'Apte avec réserve',
                        'inapte' => 'Inapte',
                        'inapte définitif' => 'Inapte définitif',
                    ]),

                TextInput::make('note')->maxLength(255),


                Section::make('Résultats')
                    ->schema([
                        // Interrogatoires Section
                        Section::make('Interrogatoires')
                            ->schema([
                                Repeater::make('resultatsInterrogatoires')
                                    ->relationship('resultats') // The base relationship
                                    ->label('')
                                    ->schema([
                                        Select::make('rubrique_id')
                                            ->label('Rubrique')
                                            ->options(
                                                Rubrique::where('type', 'interrogatoire')
                                                    ->with('appareil')
                                                    ->get()
                                                    ->mapWithKeys(fn ($rubrique) => [
                                                        $rubrique->id => $rubrique->appareil 
                                                            ? "{$rubrique->titre} ({$rubrique->appareil->nom})" 
                                                            : $rubrique->titre
                                                    ])
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                $rubrique = Rubrique::find($state);
                                                $set('appareil_id', $rubrique?->appareil_id);
                                            }),
                                        
                                        // Hidden field to store appareil_id
                                        Forms\Components\Hidden::make('appareil_id'),
                                        
                                        TextInput::make('resultat')
                                            ->label('Résultat')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->columns(2)
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                        // Ensure type is set for new records
                                        $data['type'] = 'interrogatoire';
                                        return $data;
                                    }),
                            ])
                            ->collapsible(),

                        // Examens Cliniques Section
                        Section::make('Examens Cliniques')
                            ->schema([
                                Repeater::make('resultatsExamensCliniques')
                                    ->relationship('resultats') // Same base relationship
                                    ->label('')
                                    ->schema([
                                        Select::make('rubrique_id')
                                            ->label('Rubrique')
                                            ->options(
                                                Rubrique::where('type', 'examen_clinique')
                                                    ->with('appareil')
                                                    ->get()
                                                    ->mapWithKeys(fn ($rubrique) => [
                                                        $rubrique->id => $rubrique->appareil 
                                                            ? "{$rubrique->titre} ({$rubrique->appareil->nom})" 
                                                            : $rubrique->titre
                                                    ])
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->live()
                                            ->columns(2)
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                $rubrique = Rubrique::find($state);
                                                $set('appareil_id', $rubrique?->appareil_id);
                                            }),
                                        
                                        // Hidden field to store appareil_id
                                        Forms\Components\Hidden::make('appareil_id'),
                                        
                                        Textarea::make('resultat')
                                            ->label('Observations')
                                            ->required()
                                            ->columnSpanFull(),
                                    ])
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                        // Ensure type is set for new records
                                        $data['type'] = 'examen_clinique';
                                        return $data;
                                    }),
                            ])
                            ->collapsible(),
                    ])
                    ->collapsible(),

                // --- Explorations Fonctionnelles ---
                Section::make('Explorations Fonctionnelles')->schema([
                    Repeater::make('exploration_fonctionnelle')
                        ->relationship('exploration_fonctionnelle')
                        ->schema([
                            Textarea::make('FRSP')->label('Fonction Respiratoire'),
                            Textarea::make('FCIR')->label('Fonction Circulaires'),
                            Textarea::make('FMOT')->label('Fonction Motricite'),
                        ])
                        ->columns(1),
                ])->collapsible(),

                // --- Explorations Complémentaires ---
                Section::make('Explorations Complémentaires')->schema([
                    Repeater::make('exploration_complementaire')
                        ->relationship('exploration_complementaire')
                        ->schema([
                            Textarea::make('toxic')->label('Toxicologique'),
                            Textarea::make('bio')->label('Biologique'),
                            Textarea::make('radio')->label('Radiologique'),
                        ])
                        ->columns(1),
                ])->collapsible(),

                // --- Ordonnances ---
                Section::make('Ordonnances')->schema([
                    Repeater::make('ordonnances')
                        ->relationship('ordonnances')
                        ->schema([
                            Textarea::make('recommandations')->label('Recommandations'),

                            Repeater::make('ordonnance_medicaments')
                                ->relationship('ordonnance_medicaments')
                                ->schema([
                                    Select::make('medicament_id')
                                        ->relationship('medicament', 'nom')
                                        ->label('Médicament')
                                        ->options(Medicament::all()->pluck('nom', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            TextInput::make('nom')->required(),
                                            TextInput::make('description'),
                                        ])
                                        ->createOptionUsing(fn (array $data) => Medicament::create($data)),

                                    TextInput::make('dosage')->label('Dosage')->required(),
                                    TextInput::make('duree')->label('Durée')->required(),
                                ])
                                ->columns(3)
                                ->defaultItems(1),
                        ])
                        ->columns(1),
                        ])->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('diagnostic')
            ->columns([
                Tables\Columns\TextColumn::make('medecin.nom')->label('Nom de Médecin')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('medecin.prenom')->label('Prénom de Médecin')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('medecin.specialite.nom')->label('Spécialité')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('aptitude')->label('Aptitude')->colors([
                    'success' => 'apte',
                    'danger' => 'inapte',
                    'warning' => 'inapte définitif',
                    'info' => 'apte avec reserve',
                ]),
                Tables\Columns\TextColumn::make('date_consultation')->label('Date')->date()->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Voir')->icon('heroicon-o-eye')->openUrlInNewTab(),
                Tables\Actions\EditAction::make()
                    // ->visible(function ($record) {
                    //     $user = auth()->user();
                    //     $isToday = \Illuminate\Support\Carbon::parse($record->date_consultation)->isToday();
                    //     if ($user?->isMedecin() && $record->medecin_id === $user->medecin->id) {
                    //     return $isToday;
                    //         }
                    //     return false;
                    // })
                    ->tooltip('Éditer uniquement une consultation du jour')
                    ->icon('heroicon-o-pencil'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            // Tu peux les ajouter ou les désactiver si tu les affiches déjà dans la page consultation
        ];
    }
}
