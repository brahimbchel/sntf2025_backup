<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeResource\Pages;
use App\Filament\Resources\EmployeResource\RelationManagers;
use App\Models\Employe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\BaseResource;

use Illuminate\Database\Eloquent\Model;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

        public static function getNavigationGroup(): ?string
{
    return 'Staff & Users';
}

public static function getNavigationSort(): ?int
{
    return 2; // lower = higher in group list
}

        public static function canViewAny(): bool
{
    return auth()->user()?->isAdmin();
}


    public static function canCreate(): bool
{
    return auth()->user()?->isAdmin();
}

public static function canEdit(Model $record): bool
{
    return auth()->user()?->isAdmin();
}

public static function canDelete(Model $record): bool
{
    return auth()->user()?->isAdmin();
}

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();
    $user = auth()->user();

    if (auth()->user()?->isAdmin()) {
        return $query; // Agents and admins see all consultations
    }

    if (auth()->user()?->isEmploye()) {
        return $query->where('id', $user->employe->id ?? 0);
    }

    return $query; // Fallback for other roles
}

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Informations de l\'employé')
                ->columns(2)
                ->schema([
                    // Champs liés à l'utilisateur
                    Forms\Components\TextInput::make('user.email')
                        ->label('Email')
                        ->email()
                        ->unique(User::class, 'email')
                        ->required(fn (callable $get, $context) => $context === 'create'),

                    Forms\Components\TextInput::make('user.password')
                        ->label('Mot de passe')
                        ->password()
                        ->required(fn (callable $get, $context) => $context === 'create')
                        ->minLength(6),

                    // Champs de l'employé
                    Forms\Components\TextInput::make('nom')
                        ->required()
                        ->label('Nom')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('prenom')
                        ->required()
                        ->label('Prénom')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('matricule')
                        ->required()
                        ->label('Matricule')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('fonction')
                        ->label('Fonction')
                        ->maxLength(100),

                    Select::make('departement_id')
                    ->label('Département')
                    ->searchable()
                    ->preload()
                    ->options(function () {
                        return \App\Models\Departement::with('secteur')->get()->mapWithKeys(function ($departement) {
                            $secteurNom = $departement->secteur->nom ?? 'Aucun secteur';
                            return [
                                $departement->id => $departement->nom . ' (' . $secteurNom . ')'
                            ];
                        });
                    }),

                    Forms\Components\DatePicker::make('datedenaissance')
                        ->label('Date de naissance')
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    Forms\Components\TextInput::make('adresse')
                        ->label('Adresse')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('tel')
                        ->label('Téléphone')
                        ->tel()
                        ->required()
                        ->telRegex('/^(05|06|07)[0-9]{8}$/'),

                    Select::make('gender')
                        ->label('Genre')
                        ->options([
                            'Homme' => 'Homme',
                            'Femme' => 'Femme',
                        ])
                        ->required(),

                    Select::make('groupe_sanguin')
                        ->label('Groupe sanguin')
                        ->options([
                            'A+' => 'A+',
                            'A-' => 'A-',
                            'B+' => 'B+',
                            'B-' => 'B-',
                            'AB+' => 'AB+',
                            'AB-' => 'AB-',
                            'O+' => 'O+',
                            'O-' => 'O-',
                        ]),

                    Select::make('situation_familiale')
                        ->label('Situation familiale')
                        ->options([
                            'célibataire' => 'Célibataire',
                            'marié(e)' => 'Marié(e)',
                            'divorcé(e)' => 'Divorcé(e)',
                            'veuf(ve)' => 'Veuf(ve)',
                        ]),

                    Select::make('service_national')
                        ->label('Service national')
                        ->options([
                            'accompli' => 'Accompli',
                            'dispensé' => 'Dispensé',
                            'inapte' => 'Inapte',
                        ]),

                    Select::make('etat')
                        ->label('État')
                        ->options([
                            'Actif' => 'Actif',
                            'Inactif' => 'Inactif',
                        ])
                        ->default('Actif'),
                ]),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('matricule')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('prenom')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('gender')
                ->label('sex')
                ->sortable()
                ->colors([
                    'info' => 'Homme',
                    'pink' => 'Femme',
                ]),

                Tables\Columns\TextColumn::make('departement.nom')->label('Departement'),
                
                BadgeColumn::make('etat')
                ->sortable()
                
                ->colors([
                    'success' => 'Actif',
                    'danger' => 'Inactif',
                ]),     
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label('Voir plus')
                ->icon('heroicon-m-identification')
                ->size(ActionSize::Small)
                ->color('info'),
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
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'view' => Pages\ViewEmploye::route('/{record}'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
        ];
    }
}
