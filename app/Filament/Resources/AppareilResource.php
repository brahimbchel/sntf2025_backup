<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppareilResource\Pages;
use App\Filament\Resources\AppareilResource\RelationManagers;
use App\Models\Appareil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

class AppareilResource extends Resource
{
    protected static ?string $model = Appareil::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

        public static function getNavigationGroup(): ?string
{
    return 'Centers';
}

public static function getNavigationSort(): ?int
{
    return 4;
}

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent', 'medecin']) ?? false;
    // }
// public static function canAccess(): bool
// {
//     return true;
// }

public static function canViewAny(): bool
{
    return auth()->user()?->isAdmin();
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(100),
            ]);
    }
    public static function shouldRegisterNavigation(): bool
{
    return false;
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rubriques_count')
                ->counts('rubriques')
                ->label('Rubriques'),
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
            'index' => Pages\ListAppareils::route('/'),
            'create' => Pages\CreateAppareil::route('/create'),
            'view' => Pages\ViewAppareil::route('/{record}'),
            'edit' => Pages\EditAppareil::route('/{record}/edit'),
        ];
    }
}
