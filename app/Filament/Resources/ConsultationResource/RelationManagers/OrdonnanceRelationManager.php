<?php

namespace App\Filament\Resources\ConsultationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OrdonnanceRelationManager extends RelationManager
{
    protected static string $relationship = 'ordonnances'; // nom de la relation dans le modèle Consultation

     public  function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\DatePicker::make('date_ordonnance'),
                Forms\Components\Textarea::make('recommandations')
                    ->columnSpanFull(),
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recommandations')
                    ->limit(50)
                    ->sortable(),
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
