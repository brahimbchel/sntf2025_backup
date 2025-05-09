<?php

namespace App\Filament\Resources\DossierMedicalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\RelationManagers\RelationManager;
// use Filament\Resources\RelationManagers\HasManyRelationManager;

use Filament\Tables;
use Filament\Tables\Table;

class ConsultationRelationManager extends RelationManager
// class ConsultationRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'consultations';

    protected static ?string $title = 'Consultations';

    public static function getResource(): ?string
    {
        return \App\Filament\Resources\ConsultationResource::class;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('date_consultation')
                ->required(),
            Forms\Components\TextInput::make('medecin_id')
                ->numeric()
                ->required(),
            Forms\Components\Textarea::make('diagnostic')
                ->label('Diagnostic')
                ->columnSpanFull()
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_consultation')->date()->sortable(),
                Tables\Columns\TextColumn::make('medecin_id')->sortable(),
                Tables\Columns\TextColumn::make('diagnostic')->limit(30),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
