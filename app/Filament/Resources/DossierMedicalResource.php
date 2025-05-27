<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DossierMedicalResource\RelationManagers\ConsultationRelationManager;
use App\Filament\Resources\DossierMedicalResource\Pages;
use App\Models\DossierMedical;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\BaseResource;


class DossierMedicalResource extends Resource
{
    protected static string $relationship = 'consultations'; // nom de la relation Eloquent dans DossierMedical
    protected static ?string $model = DossierMedical::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function canCreate(): bool
{
    return false;
}

    public static function getNavigationGroup(): ?string
{
    return 'Medical Management';
}

public static function getNavigationSort(): ?int
{
    return 1;
}
    
     public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // If the user is admin or medecin, show everything
        if ($user->isAdmin() || $user->isMedecin()) {
            return parent::getEloquentQuery();
        }

        // Show only the dossier for the logged-in user's employee ID
        return parent::getEloquentQuery()
            ->where('emp_id', $user->employe->id ?? 0);
    }

    public static function form(Form $form): Form
{
    return $form->schema([

        Section::make('Activité Professionnelle Antérieure')
            ->icon('heroicon-m-briefcase')
            ->iconColor('gray')
            ->schema([
                MarkdownEditor::make('activite_professionnelles_anterieures')
                    ->label('Activités antérieures'),
            ])
            ->collapsible(),

        Section::make('Antécédents Familiaux')
            ->icon('heroicon-m-user-group')
            ->iconColor('gray')
            ->schema([
                MarkdownEditor::make('antecedents_familiaux')
                    ->label('Antécédents familiaux'),
            ])
            ->collapsible(),

        Section::make('Antécédents Personnels')
            ->icon('heroicon-m-clipboard-document-list')
            ->iconColor('gray')
            ->schema([
                MarkdownEditor::make('antecedents_personnels')
                    ->label('Antécédents personnels'),
            ])
            ->collapsible(),

        Section::make('Maladies Professionnelles')
            ->icon('heroicon-m-document-duplicate')
            ->iconColor('gray')
            ->schema([
                MarkdownEditor::make('maladies_professionnelles')
                    ->label('Maladies professionnelles'),
            ])
            ->collapsible(),

        Section::make('Observations')
            ->icon('heroicon-m-pencil-square')
            ->iconColor('gray')
            ->schema([
                MarkdownEditor::make('observations')
                    ->label('Observations'),
            ])
            ->collapsible(),
    ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('employe.nom')
                ->label('Nom')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('employe.prenom')
                ->label('Prénom')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('employe.matricule')
                ->label('Matricule')
                ->sortable()
                ->searchable(),
            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->isMedecin()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);

    }

    public static function getRelations(): array
    {
        return [
            ConsultationRelationManager::class,
           // MetaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDossierMedicals::route('/'),
            // 'create' => Pages\CreateDossierMedical::route('/create'),
            'view' => Pages\ViewDossierMedical::route('/{record}'),
            'edit' => Pages\EditDossierMedical::route('/{record}/edit'),
        ];
    }
}
