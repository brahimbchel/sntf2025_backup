<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedecinResource\Pages;
use App\Filament\Resources\MedecinResource\RelationManagers;
use App\Models\Medecin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class MedecinResource extends Resource
{
    protected static ?string $model = Medecin::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('prenom')
                    ->required()
                    ->maxLength(100),
                
                Forms\Components\TextInput::make('tel')
                    ->tel()
                    ->maxLength(50),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(50),
                Select::make('Specialite_id')->label('Specialite')->relationship('Specialite', 'nom')->searchable(),
                Select::make('CentreMedical_id')->label('CMD')->relationship('Centre_Medical', 'nom')->searchable(),
            Forms\Components\Toggle::make('gender'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->searchable(),
                Tables\Columns\IconColumn::make('gender')
                    ->boolean(),
                Tables\Columns\TextColumn::make('tel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                
                    Tables\Columns\TextColumn::make('specialite.nom')->label('specialite'),
                    Tables\Columns\TextColumn::make('Centre_Medical.nom')->label('CMD'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedecins::route('/'),
            'create' => Pages\CreateMedecin::route('/create'),
            'view' => Pages\ViewMedecin::route('/{record}'),
            'edit' => Pages\EditMedecin::route('/{record}/edit'),
        ];
    }
}
