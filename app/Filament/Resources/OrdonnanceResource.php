<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdonnanceResource\Pages;
use App\Filament\Resources\OrdonnanceResource\RelationManagers;
use App\Models\Ordonnance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OrdonnanceResource extends Resource
{
    protected static ?string $model = Ordonnance::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

        public static function canViewAny(): bool
    {
        return Auth::user()?->hasAnyRole([ 'medecin']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('consultation_id')
                    ->numeric(),
                Forms\Components\DatePicker::make('date_ordonnance'),
                Forms\Components\Textarea::make('recommandations')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consultation_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_ordonnance')
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
            'index' => Pages\ListOrdonnances::route('/'),
            'create' => Pages\CreateOrdonnance::route('/create'),
            'view' => Pages\ViewOrdonnance::route('/{record}'),
            'edit' => Pages\EditOrdonnance::route('/{record}/edit'),
        ];
    }
}
