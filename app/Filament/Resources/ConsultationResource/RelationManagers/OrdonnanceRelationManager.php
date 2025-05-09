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
                // Forms\Components\TextInput::make('consultation_id')
                //     ->numeric(),
                // Forms\Components\DatePicker::make('date_ordonnance'),
                // Forms\Components\Textarea::make('recommandations')
                //     ->columnSpanFull(),
                    
                Forms\Components\DatePicker::make('date_ordonnance')
                    ->label('Date de l\'ordonnance')
                    ->required(),
                
                Forms\Components\Textarea::make('recommandations')
                    ->label('Recommandations')
                    ->placeholder('Entrer les recommandations ici...')
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consultation_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_ordonnance')
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
