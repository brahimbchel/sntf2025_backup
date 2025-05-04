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

class DossierMedicalResource extends Resource
{
    protected static string $relationship = 'consultations'; // nom de la relation Eloquent dans DossierMedical
    protected static ?string $model = DossierMedical::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(100),
                Select::make('emp_id')->label('Employer')->relationship('Employe', 'nom')->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Employe.nom')->label('Employe'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            ConsultationRelationManager::class,
           // MetaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDossierMedicals::route('/'),
            'create' => Pages\CreateDossierMedical::route('/create'),
            'view' => Pages\ViewDossierMedical::route('/{record}'),
            'edit' => Pages\EditDossierMedical::route('/{record}/edit'),
        ];
    }
}
