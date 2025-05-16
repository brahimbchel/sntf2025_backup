<?php
namespace App\Filament\Resources\DossierMedicalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\DossierMedicalResource\RelationManagers\ExplorationFonctionnelleRelationManager;
use App\Filament\Resources\DossierMedicalResource\RelationManagers\ExplorationComplementaireRelationManager;
use App\Filament\Resources\DossierMedicalResource\RelationManagers\OrdonnanceRelationManager;
use Filament\Tables;
use Livewire\Livewire;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;


class ConsultationRelationManager extends RelationManager
{
    protected static string $relationship = 'consultations';

    public function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Textarea::make('diagnostic')
                ->required()
                -> columnSpanFull()
                ->maxLength(255),

           Select::make('aptitude')
                ->label('Aptitude')
                ->options([
                    'apte' => 'Apte',
                    'apte avec reserve' => 'apte avec reserve',
                    'inapte' => 'Inapte',
                    'inapte définitif' => 'inapte définitif'
                ]),

            Forms\Components\TextInput::make('note')
                ->required()
                ->maxLength(255),

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
    Tables\Actions\ViewAction::make()
        ->label('Voir')
        ->icon('heroicon-o-eye')
        ->openUrlInNewTab(),

    Tables\Actions\EditAction::make()
        ->visible(fn ($record) => \Illuminate\Support\Carbon::parse($record->date_consultation)->isToday())
        ->tooltip('Éditer uniquement une consultation du jour')
        ->icon('heroicon-o-pencil'),

    Tables\Actions\DeleteAction::make(),
])

            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

     public static function getRelations(): array
    {
        return [
            ExplorationFonctionnelleRelationManager::class,
            ExplorationComplementaireRelationManager::class,
            OrdonnanceRelationManager::class,
        ];
    }

}
