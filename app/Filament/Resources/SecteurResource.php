<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SecteurResource\Pages;
use App\Filament\Resources\SecteurResource\RelationManagers;
use App\Models\Secteur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

class SecteurResource extends Resource
{
    protected static ?string $model = Secteur::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

        // 🔒 Only admins can see this resource in sidebar
    // public static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()?->isAdmin();
    // }

    // 🔐 Only admins can access this resource at all
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
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
            'index' => Pages\ListSecteurs::route('/'),
            'create' => Pages\CreateSecteur::route('/create'),
            'view' => Pages\ViewSecteur::route('/{record}'),
            'edit' => Pages\EditSecteur::route('/{record}/edit'),
        ];
    }
}
