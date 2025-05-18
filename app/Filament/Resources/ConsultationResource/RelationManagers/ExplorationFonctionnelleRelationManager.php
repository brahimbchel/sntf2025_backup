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
                    ->label('Fonction Respiratoire (FRSP)')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('FCIR')
                    ->label('Fonction Circulatoire (FCIR)')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('FMOT')
                    ->label('Fonction Motrice (FMOT)')
                    ->columnSpanFull(),

                // Forms\Components\DatePicker::make('date_exploration')
                //     ->label('Date de l\'exploration'),
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consultationid')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('FRSP')
                    ->label('Fonction Respiratoire (FRSP)'),
                Tables\Columns\TextColumn::make('FCIR')
                    ->label('Fonction Circulatoire (FCIR)'),
                Tables\Columns\TextColumn::make('FMOT')
                    ->label('Fonction Motrice (FMOT)'),
                // Tables\Columns\TextColumn::make('date_exploration')
                //     ->date()
                //     ->sortable(),
            ])
            ->filters([
                //
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
