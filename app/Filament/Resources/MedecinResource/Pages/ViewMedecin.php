<?php

namespace App\Filament\Resources\MedecinResource\Pages;

use App\Filament\Resources\MedecinResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;

class ViewMedecin extends ViewRecord
{
    protected static string $resource = MedecinResource::class;

    public function getInfolist(string $name): ?\Filament\Infolists\Infolist
    {
      return \Filament\Infolists\Infolist::make()
        ->record($this->record)
        ->schema([
            \Filament\Infolists\Components\Section::make('Informations du Médecin')
                ->columns(2)  // Deux colonnes
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('nom')->label('Nom'),
                    \Filament\Infolists\Components\TextEntry::make('prenom')->label('Prénom'),
                    \Filament\Infolists\Components\TextEntry::make('tel')->label('Téléphone'),
                    \Filament\Infolists\Components\TextEntry::make('gender')->label('Sexe'),
                    \Filament\Infolists\Components\TextEntry::make('specialite.nom')->label('Spécialité'),
                    \Filament\Infolists\Components\TextEntry::make('centre_medical.nom')->label('Centre Médical'),
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
