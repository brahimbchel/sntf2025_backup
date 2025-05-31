<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedecinResource\Pages;
use App\Filament\Resources\MedecinResource\RelationManagers;
use App\Models\Medecin;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Filament\Resources\BaseResource;

class MedecinResource extends Resource
{
    protected static ?string $model = Medecin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

        public static function getNavigationGroup(): ?string
{
    return 'Staff & Users';
}

public static function getNavigationSort(): ?int
{
    return 3; // lower = higher in group list
}

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

            public static function canViewAny(): bool
{
    return auth()->user()?->isAdmin();
}

public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with(['user', 'specialite', 'Centre_Medical']);
}


        public static function form(Form $form): Form
{
    return $form
        ->schema([
                    Forms\Components\Section::make('Informations du Médecin')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('user.email')
                ->label('Email')
                ->email()
                ->required(fn (callable $get, $context) => $context === 'create'),
                        
                    Forms\Components\TextInput::make('user.password')
                        ->label('Mot de passe')
                        ->password()
                        ->minLength(6)
                        ->required(fn (callable $get, $context) => $context === 'create'),

                    Forms\Components\TextInput::make('nom')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\TextInput::make('prenom')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\TextInput::make('tel')
                        ->label("Numéro de téléphone")
                        ->telRegex('/^(05|06|07)[0-9]{8}$/')
                        ->required(),

                    Select::make('Specialite')
                        ->label('Spécialité')
                        ->relationship('Specialite', 'nom')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('CentreMedical_id')
                        ->label('CMS')
                        ->relationship('Centre_Medical', 'nom')
                        ->preload()
                        ->searchable(),

                    Select::make('gender')
                        ->label('Sexe')
                        ->options([
                            'Homme' => 'Homme',
                            'Femme' => 'Femme',
                        ])
                        ->required(),
                ])
        ]);
}



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->sortable()
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->sortable()
                    ->label('Prénom')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('gender')
                ->label('Sex')
                ->sortable()
                ->colors([
                    'info' => 'Homme',
                    'pink' => 'Femme',
                ]),
    
                Tables\Columns\TextColumn::make('tel')
                    ->label('Téléphone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->sortable()
                    ->label('Email')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('specialite.nom')
                    ->sortable()
                    ->label('Spécialité')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Centre_Medical.nom')
                    ->label('CMS')
                    ->sortable()
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
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMedecins::route('/'),
            'create' => Pages\CreateMedecin::route('/create'),
            'view' => Pages\ViewMedecin::route('/{record}'),
            'edit' => Pages\EditMedecin::route('/{record}/edit'),
        ];
    }
}
