<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExplorationComplementaireResource\Pages;
use App\Filament\Resources\ExplorationComplementaireResource\RelationManagers;
use App\Models\ExplorationComplementaire;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ExplorationComplementaireResource extends Resource
{
    protected static ?string $model = ExplorationComplementaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

        public static function canViewAny(): bool
    {
        return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent', 'medecin']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('consultationidC')
                    ->numeric(),
                Forms\Components\TextInput::make('radio')
                    ->maxLength(100),
                Forms\Components\TextInput::make('bio')
                    ->maxLength(100),
                Forms\Components\TextInput::make('toxic')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('date_exploration'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consultationidC')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListExplorationComplementaires::route('/'),
            'create' => Pages\CreateExplorationComplementaire::route('/create'),
            'view' => Pages\ViewExplorationComplementaire::route('/{record}'),
            'edit' => Pages\EditExplorationComplementaire::route('/{record}/edit'),
        ];
    }
}
