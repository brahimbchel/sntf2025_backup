<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Filament\Resources\ConsultationResource\RelationManagers;
use App\Models\Consultation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('dossier_id')
                    ->numeric(),
                Forms\Components\TextInput::make('medecin_id')
                    ->numeric(),
                Forms\Components\DatePicker::make('date_consultation'),
                Forms\Components\Textarea::make('diagnostic')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dossier_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('medecin_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_consultation')
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

   

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConsultations::route('/'),
            'create' => Pages\CreateConsultation::route('/create'),
            'view' => Pages\ViewConsultation::route('/{record}'),
            'edit' => Pages\EditConsultation::route('/{record}/edit'),
        ];
    }
    public static function getRelations(): array
{
    return [
        RelationManagers\OrdonnanceRelationManager::class,
        RelationManagers\ExplorationComplementaireRelationManager::class,
        RelationManagers\ExplorationFonctionnelleRelationManager::class,
       // RelationManagers\ResultatRelationManager::class,
    ];
}

}
