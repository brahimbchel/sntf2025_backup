<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use App\Filament\Resources\EmployeResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Actions;

class ViewEmploye extends ViewRecord
{
    protected static string $resource = EmployeResource::class;

    public function getInfolist(string $name): ?\Filament\Infolists\Infolist
    {
        return \Filament\Infolists\Infolist::make()
            ->record($this->record)
            ->schema([
                \Filament\Infolists\Components\Section::make('Informations de l\'employé')
                    ->columns(2)
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('nom')->label('Nom'),
                        \Filament\Infolists\Components\TextEntry::make('prenom')->label('Prénom'),
                        \Filament\Infolists\Components\TextEntry::make('tel')->label('Téléphone'),
                        \Filament\Infolists\Components\TextEntry::make('gender')->label('Sexe'),
                        \Filament\Infolists\Components\TextEntry::make('matricule')->label('Matricule'),
                        \Filament\Infolists\Components\TextEntry::make('fonction')->label('Fonction'),
                        \Filament\Infolists\Components\TextEntry::make('departement.nom')->label('Département'),
                        \Filament\Infolists\Components\TextEntry::make('user.email')->label('Email'),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
