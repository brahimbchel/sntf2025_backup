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
use App\Filament\Resources\BaseResource;

class MedecinResource extends Resource
{
    protected static ?string $model = Medecin::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->hasAnyRole(['admin', 'Super Admin', 'admin-agent']) ?? false;
    // }

            public static function canViewAny(): bool
{
    return auth()->user()?->isAdmin();
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('user.email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email'),

                        Forms\Components\TextInput::make('user.name')->required(),

                        Forms\Components\TextInput::make('user.password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->minLength(6),
                            // ->dehydrated(fn ($state) => filled($state)),
                            // ->dehydrated(false), // Don't save to Employe model
                    ]),
                Forms\Components\Section::make('Medecin Information')
                    ->schema([
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

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(50),

                    Select::make('Specialite')->label('Specialite')->relationship('Specialite', 'nom')->preload()->searchable()->required(),
                    Select::make('CentreMedical_id')->label('CMS')->relationship('Centre_Medical', 'nom')->preload()->searchable(),
                
                    Select::make('gender')
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('gender')
                ->label('sex')
                ->sortable()
                ->colors([
                    'info' => 'Homme',
                    'pink' => 'Femme',
                ]),
    
                Tables\Columns\TextColumn::make('tel')
                    ->label('téléphone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('specialite.nom')->label('specialité')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('Centre_Medical.nom')->label('CMS')
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
