<?php
namespace App\Filament\Resources\DossierMedicalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Livewire\Livewire;
use Filament\Tables\Table;

class ConsultationRelationManager extends RelationManager
{
    protected static string $relationship = 'consultations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('diagnostic')
                    ->required()
                    ->maxLength(255),

                // Utilisation des onglets
                Forms\Components\Tabs::make('consultation_tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Ordonnances')
                            ->schema([
                                $this->getLivewireComponent('exploration-complementaire-table')
                            ]),

                        Forms\Components\Tabs\Tab::make('Explorations Fonctionnelles')
                            ->schema([
                                $this->getLivewireComponent('exploration-fonctionnelle-table')
                            ]),

                        Forms\Components\Tabs\Tab::make('Explorations Complémentaires')
                            ->schema([
                                $this->getLivewireComponent('exploration-complementaire-table')
                            ]),
                    ])
            ]);
    }

    private function getLivewireComponent(string $componentName)
    {
        // Assure-toi que le composant Livewire existe et est bien chargé
        try {
            return Livewire::component($componentName, ['consultationId' => $this->getOwnerRecord()->id]);
        } catch (\Exception $e) {
            // Si une exception se produit, renvoyer un message d'erreur dans le formulaire
            return Forms\Components\TextInput::make('error')
                ->default('Erreur de chargement du composant Livewire : ' . $e->getMessage())
                ->disabled();
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('diagnostic')
            ->columns([
            
            Tables\Columns\TextColumn::make('medecin.nom')
                ->label('Nom de Médecin')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('medecin.prenom')
                ->label('Prénom de Médecin')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('medecin.specialite.nom')
                ->label('specialité')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('date_consultation')
                ->label('Date')
                ->date()
                ->sortable(),
            ])
            ->filters([/* Filter actions */])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                
        ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
