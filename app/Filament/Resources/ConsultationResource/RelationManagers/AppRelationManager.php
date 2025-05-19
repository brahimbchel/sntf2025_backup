<?php

namespace App\Filament\Resources\ConsultationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class AppRelationManager extends RelationManager
{
    protected static string $relationship = 'resultats'; // should exist in Consultation model

    // public  function form(Form $form):
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('rubrique_id')
                    ->relationship('rubrique', 'titre')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DatePicker::make('dateR')
                    ->label('Date du Résultat')
                    ->required(),

                Forms\Components\TextInput::make('resultat')
                    ->label('Résultat')
                    ->maxLength(100)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rubrique.appareil.nom')
                    ->label('Appareil')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('rubrique.titre')
                    ->label('Rubrique')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('dateR')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('resultat')
                    ->label('Résultat')
                    ->searchable(),
            ])
            ->filters([
                // you can add filters by rubrique, date range, etc
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
