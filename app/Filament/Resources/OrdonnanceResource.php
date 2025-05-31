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
use App\Filament\Resources\BaseResource;

class OrdonnanceResource extends Resource
{
    protected static ?string $model = Ordonnance::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

        public static function getNavigationGroup(): ?string
{
    return 'Medical Management';
}

public static function getNavigationSort(): ?int
{
    return 4;
}

    //     public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole([ 'medecin']) ?? false;
    // }

                public static function canViewAny(): bool
{
    return auth()->user()?->isAdmin() || auth()->user()?->isMedecin();
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('consultation_id')
                    ->numeric(),
                Forms\Components\Textarea::make('recommandations')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('consultation_id'),
                Tables\Columns\TextColumn::make('consultation.dossier_medical.employe.nom')
                    ->label('Nom')->searchable(),
                Tables\Columns\TextColumn::make('consultation.dossier_medical.employe.prenom')
                    ->label('Prénom')->searchable(),
                Tables\Columns\TextColumn::make('consultation.dossier_medical.employe.matricule')
                    ->label('Matricule')->searchable(),
                Tables\Columns\TextColumn::make('consultation.date_consultation')->date('d/m/Y')
                    ->label('Date')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record): bool =>
                     auth()->user()->isMedecin() && $record->consultation->medecin_id === auth()->user()->medecin->id
                    ),
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
            //'create' => Pages\CreateOrdonnance::route('/create'),
            'view' => Pages\ViewOrdonnance::route('/{record}'),
            'edit' => Pages\EditOrdonnance::route('/{record}/edit'),
        ];
    }
}
