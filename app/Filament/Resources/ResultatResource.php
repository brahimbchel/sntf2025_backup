<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultatResource\Pages;
use App\Filament\Resources\ResultatResource\RelationManagers;
use App\Models\Resultat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

class ResultatResource extends Resource
{
    protected static ?string $model = Resultat::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    
        public static function getNavigationGroup(): ?string
{
    return 'Medical Management';
}

public static function getNavigationSort(): ?int
{
    return 8;
}

//             public static function canViewAny(): bool
// {
//     return auth()->user()?->isAdmin() || auth()->user()?->isMedecin();
// }

            public static function canViewAny(): bool
{
    return false;
}


    // // this is the corect one
    //  ublic static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['medecin']) ?? false;
    // }

    // temporary
    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent', 'medecin']) ?? false;
    // }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('consultation_id')
                    ->relationship('consultation', 'id') // or use a custom title
                    ->required(),
                Forms\Components\Select::make('rubrique_id')
                    ->relationship('rubrique', 'titre')
                    ->required(),
                Forms\Components\DatePicker::make('dateR')
                    ->required(),
                Forms\Components\TextInput::make('resultat')
                    ->maxLength(100),
            ]);
    }


    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('rubrique.titre') // show rubrique title
                ->label('Rubrique')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('consultation.id') // or maybe consultation.patient.nom if you have a relation
                ->label('Consultation')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('dateR')
                ->date()
                ->sortable(),

            Tables\Columns\TextColumn::make('resultat')
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

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             Tables\Columns\TextColumn::make('rubrique_id')
    //                 ->numeric()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('consultation_id')
    //                 ->numeric()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('dateR')
    //                 ->date()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('resultat')
    //                 ->searchable(),
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->actions([
    //             Tables\Actions\ViewAction::make(),
    //             Tables\Actions\EditAction::make(),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResultats::route('/'),
            'create' => Pages\CreateResultat::route('/create'),
            'view' => Pages\ViewResultat::route('/{record}'),
            'edit' => Pages\EditResultat::route('/{record}/edit'),
        ];
    }
}
