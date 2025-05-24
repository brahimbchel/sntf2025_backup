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


                

        // Section::make('Résultats')
        //     ->schema([
        //         // --- Sous-section Interrogatoires ---
        //         Section::make('Interrogatoires')
        //             ->schema([
        //                 Repeater::make('resultats')
        //                     ->label('Résultats Interrogatoires')
        //                     ->relationship('resultats')
        //                     ->schema([
        //                         Forms\Components\Select::make('rubrique_id')
        //                             ->label('Rubrique')
        //                             ->options(
        //                                 Rubrique::with('appareil')->get()->mapWithKeys(function ($rubrique) {
        //                                     $appareilNom = $rubrique->appareil?->nom ?? 'Sans appareil';
        //                                     return [$rubrique->id => "{$rubrique->titre} ({$appareilNom})"];
        //                                 })->toArray()
        //                             )
        //                             ->required()
        //                             ->searchable()
        //                             ->preload()
        //                             ->createOptionForm([
        //                                 Forms\Components\TextInput::make('titre')
        //                                     ->label('Titre de la rubrique')
        //                                     ->required(),
        //                                 Forms\Components\Select::make('App_id')
        //                                     ->label('Appareil')
        //                                     ->relationship('appareil', 'nom')
        //                                     ->required()
        //                                     ->createOptionForm([
        //                                         Forms\Components\TextInput::make('nom')
        //                                             ->label('Nom appareil')
        //                                             ->required(),
        //                                     ]),
        //                             ]),
        //                         Forms\Components\TextInput::make('resultat')
        //                             ->label('Résultat')
        //                             ->required()
        //                             ->maxLength(100),
        //                     ])
        //                     ->columns(2),
        //             ])
        //             ->collapsible(),

        //         // --- Sous-section Examen Clinique ---
        //         Section::make('Examen Clinique')
        //             ->schema([
        //                 Repeater::make('examens_cliniques')
        //                     ->label('Examens Cliniques')
        //                     ->schema([
        //                         Forms\Components\Select::make('appareil_id')
        //                             ->label('Appareil')
        //                             ->options(
        //                                 Appareil::all()->pluck('nom', 'id')->toArray()
        //                             )
        //                             ->required()
        //                             ->reactive()
        //                             ->afterStateUpdated(function ($state, callable $set) {
        //                                 $appareil = Appareil::find($state);
        //                                 $set('examenClinique', $appareil?->examenClinique);
        //                             })
        //                             ->createOptionForm([
        //                                 Forms\Components\TextInput::make('nom')
        //                                     ->label('Nom appareil')
        //                                     ->required(),
        //                                 Forms\Components\Textarea::make('examenClinique')
        //                                     ->label('Examen Clinique')
        //                                     ->rows(2),
        //                             ]),

        //                         Forms\Components\Textarea::make('examenClinique')
        //                             ->label('Examen Clinique')
        //                             ->dehydrated(false)
        //                             ->rows(3),
        //                     ])
        //                     ->columns(2),
        //             ])
        //             ->collapsible(),
        //                         ]),

        

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
                    ->visible(function ($record) {
                                                $user = auth()->user();
                                                $isToday = \Illuminate\Support\Carbon::parse($record->date_consultation)->isToday();
                                                if ($user?->isMedecin() && $record->medecin_id === $user->medecin->id) {
                                                return $isToday;
                                                    }
                                                return false;
    })
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
        ];
    }
}
