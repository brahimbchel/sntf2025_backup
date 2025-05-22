<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdonnanceMedicamentResource\Pages;
use App\Filament\Resources\OrdonnanceMedicamentResource\RelationManagers;
use App\Models\OrdonnanceMedicament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

class OrdonnanceMedicamentResource extends Resource
{
    protected static ?string $model = OrdonnanceMedicament::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

        public static function getNavigationGroup(): ?string
{
    return 'Medical Management';
}

public static function getNavigationSort(): ?int
{
    return 5;
}

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['medecin']) ?? false;
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ordonnance_id')
                    ->numeric(),
                Forms\Components\TextInput::make('medicament_id')
                    ->numeric(),
                Forms\Components\TextInput::make('dosage')
                    ->maxLength(100),
                Forms\Components\TextInput::make('duree')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ordonnance_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('medicament_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dosage')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duree')
                    ->searchable(),
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
            'index' => Pages\ListOrdonnanceMedicaments::route('/'),
            'create' => Pages\CreateOrdonnanceMedicament::route('/create'),
            'view' => Pages\ViewOrdonnanceMedicament::route('/{record}'),
            'edit' => Pages\EditOrdonnanceMedicament::route('/{record}/edit'),
        ];
    }
}
