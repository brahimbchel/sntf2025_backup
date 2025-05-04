<?php

namespace App\Filament\Resources\ConsultationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ExplorationFonctionnelleRelationManager extends RelationManager
{
    protected static string $relationship = 'exploration_fonctionnelle'; // nom de la relation dans le modèle Consultation

     public  function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Textarea::make('FRSP')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('FCIR')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('FMOT')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date_exploration'),
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consultationid')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_exploration')
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


}
