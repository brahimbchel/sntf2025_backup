<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicamentResource\Pages;
use App\Filament\Resources\MedicamentResource\RelationManagers;
use App\Models\Medicament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

class MedicamentResource extends Resource
{
    protected static ?string $model = Medicament::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';

    //    public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['medecin']) ?? false;
    // }

        public static function canViewAny(): bool
{
    return auth()->user()?->isMedecin();
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
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
            'index' => Pages\ListMedicaments::route('/'),
            'create' => Pages\CreateMedicament::route('/create'),
            'view' => Pages\ViewMedicament::route('/{record}'),
            'edit' => Pages\EditMedicament::route('/{record}/edit'),
        ];
    }
}
