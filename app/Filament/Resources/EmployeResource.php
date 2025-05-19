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


class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

        public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->hasRole('admin') || $user->hasRole('agent')) {
            return $query; // Agents and admins see all consultations
        }

        if ($user->hasRole('employe')) {
            return $query->where('id', $user->employe->id ?? 0);
        }

        return $query; // Fallback for other roles like medecin in this case
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
                Forms\Components\Section::make('Employe Information')
                ->schema([
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
                    ->maxLength(100),
             
                Select::make('departement_id')->label('departement')->preload()->relationship('Departement', 'nom')->searchable(),
            
                Forms\Components\DatePicker::make('datedenaissance')
                    ->label('Date de naissance')
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                
                Select::make('gender')
                    ->options([
                        'Homme' => 'Homme',
                        'Femme' => 'Femme',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('adresse')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tel')
                    ->label('Numéro de téléphone')
                    ->required()
                    ->telRegex('/^(05|06|07)[0-9]{8}$/')
                    ->tel(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('E-mail')
                    ->maxLength(50),

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
                    ->options([
                        'Actif' => 'Actif',
                        'Inactif' => 'Inactif',
                    ])
                    ->default('draft')
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
