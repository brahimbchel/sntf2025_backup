<?php

namespace App\Filament\Resources\ConsultationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ExplorationComplementaireRelationManager extends RelationManager
{
    protected static string $relationship = 'exploration_fonctionnelle'; // nom de la relation dans le modèle Consultation

     public  function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('radio')
                    ->maxLength(100),
                Forms\Components\TextInput::make('bio')
                    ->maxLength(100),
                Forms\Components\TextInput::make('toxic')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('date_exploration'),
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('radio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('toxic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_exploration')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            Tables\Actions\CreateAction::make()
            ])
            ->headerActions([
            Tables\Actions\CreateAction::make()
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


}
