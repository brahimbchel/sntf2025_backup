<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeResource\Pages;
use App\Filament\Resources\EmployeResource\RelationManagers;
use App\Models\Employe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

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
                Forms\Components\TextInput::make('fonction')
                    ->maxLength(100),
             
                             Select::make('departement_id')->label('departement')->relationship('Departement', 'nom')->searchable(),
            
                Forms\Components\DatePicker::make('datedenaissance'),
                Forms\Components\Toggle::make('gender'),
                Forms\Components\TextInput::make('adresse')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tel')
                    ->tel()
                    ->maxLength(50),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(50),
                Forms\Components\Toggle::make('etat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                     ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('prenom')
                    ->searchable()
                     ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('fonction')
                    ->searchable()
                     ->sortable()
                    ->toggleable(),

              Tables\Columns\TextColumn::make('departement.nom')->label('Dept'),

                Tables\Columns\TextColumn::make('datedenaissance')
                    ->date()
                     ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('gender')
                    ->boolean() 
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('adresse')
                    ->searchable()
                     ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tel')
                    ->searchable()
                     ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                     ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('etat')
                    ->boolean()
                     ->sortable()
                    ->toggleable(),

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
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'view' => Pages\ViewEmploye::route('/{record}'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
        ];
    }
}
