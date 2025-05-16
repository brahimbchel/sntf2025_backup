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



class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        
                Select::make('dossier_id')
                ->label('Employé')
                ->options(
                    \App\Models\DossierMedical::with('employe') // Charger les employés associés aux dossiers
                        ->get()
                        ->mapWithKeys(fn ($dossier) => [
                            $dossier->id => $dossier->employe->nom . ' ' . $dossier->employe->prenom
                        ])
                )
                ->searchable()
                ->preload()
                ->required(),


                Select::make('medecin_id')
                ->label('Médecin')
                ->options(function () {
                    return Medecin::with('specialite')->get()->mapWithKeys(function ($medecin) {
                        $specialite = $medecin->specialite->nom ?? 'Aucune spécialité';
                        return [$medecin->id => $medecin->nom . ' ' . $medecin->prenom . ' (' . $specialite . ')'];
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
                ->required(),

            // Select::make('aptitude')
            //     ->label('Aptitude')
            //     ->options([
            //         'apte' => 'Apte',
            //         'apte avec reserve' => 'apte avec reserve',
            //         'inapte' => 'Inapte',
            //         'inapte définitif' => 'inapte définitif'
            //     ]),

            Forms\Components\DatePicker::make('date_consultation')
                ->displayFormat('d/m/Y')
                ->label('Date de Rendez-Vous')
                ->minDate(now()->addDay(1)),

            // Forms\Components\Textarea::make('diagnostic')
            //     ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('dossier_medical.employe.nom')
                ->label('Nom Employé')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('dossier_medical.employe.prenom')
                ->label('Prénom Employé')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('medecin.nom')
                ->label('Nom Médecin')
                ->sortable()
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
            
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
       // RelationManagers\ResultatRelationManager::class,
    ];
}

}
