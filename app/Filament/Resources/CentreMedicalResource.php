<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentreMedicalResource\Pages;
use App\Filament\Resources\CentreMedicalResource\RelationManagers;
use App\Models\CentreMedical;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CentreMedicalResource extends Resource
{
    protected static ?string $model = CentreMedical::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

     public static function canViewAny(): bool
    {
        return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent', 'medecin']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('adresse')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telephone')
                    ->tel()
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adresse')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
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
            'index' => Pages\ListCentreMedicals::route('/'),
            'create' => Pages\CreateCentreMedical::route('/create'),
            'view' => Pages\ViewCentreMedical::route('/{record}'),
            'edit' => Pages\EditCentreMedical::route('/{record}/edit'),
        ];
    }
}
