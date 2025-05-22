<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExplorationFonctionnelleResource\Pages;
use App\Filament\Resources\ExplorationFonctionnelleResource\RelationManagers;
use App\Models\ExplorationFonctionnelle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

class ExplorationFonctionnelleResource extends Resource
{
    protected static ?string $model = ExplorationFonctionnelle::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

            public static function canViewAny(): bool
{
    // return auth()->user()?->isAdmin();
    return false;
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('consultationid')
                    ->numeric(),
                Forms\Components\Textarea::make('FRSP')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('FCIR')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('FMOT')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date_exploration'),
            ]);
    }

    public static function table(Table $table): Table
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExplorationFonctionnelles::route('/'),
            'create' => Pages\CreateExplorationFonctionnelle::route('/create'),
            'view' => Pages\ViewExplorationFonctionnelle::route('/{record}'),
            'edit' => Pages\EditExplorationFonctionnelle::route('/{record}/edit'),
        ];
    }
}
