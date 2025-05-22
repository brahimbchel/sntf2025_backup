<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RubriqueResource\Pages;
use App\Filament\Resources\RubriqueResource\RelationManagers;
use App\Models\Rubrique;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

class RubriqueResource extends Resource
{
    protected static ?string $model = Rubrique::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

            public static function getNavigationGroup(): ?string
{
    return 'Centers';
}

public static function getNavigationSort(): ?int
{
    return 5;
}

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent', 'medecin']) ?? false;
    // }

    public static function canViewAny(): bool
{
    return auth()->user()?->isAdmin();
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('App_id')
                    ->relationship('appareil', 'nom')
                    ->required(),
                Forms\Components\TextInput::make('titre')
                    ->maxLength(100),
                Forms\Components\Toggle::make('visible')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('App_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('titre')
                    ->searchable(),
                Tables\Columns\IconColumn::make('visible')
                    ->boolean(),
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
            'index' => Pages\ListRubriques::route('/'),
            'create' => Pages\CreateRubrique::route('/create'),
            'view' => Pages\ViewRubrique::route('/{record}'),
            'edit' => Pages\EditRubrique::route('/{record}/edit'),
        ];
    }
}
