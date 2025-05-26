<?php

namespace App\Filament\Resources\ConsultationResource\Pages;

use App\Filament\Resources\ConsultationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Tabs;

class ViewConsultation extends ViewRecord
{
    protected static string $resource = ConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->visible(fn () => auth()->user()?->isAdmin()),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Consultation Details')
                ->tabs([
                    Tabs\Tab::make('Details')
                        ->schema([
                            // Add fields for general consultation details
                            Forms\Components\TextInput::make('diagnostic')
                                ->label('Diagnostic'),
                            // Add more fields as necessary
                        ]),
                     Tabs\Tab::make('Ordonnances')
                    ->schema([
                        Table::make('ordonnances')
                            ->columns([
                                TextColumn::make('medicaments.nom')
                                    ->label('Nom du Médicament'),
                                TextColumn::make('medicaments.dosage')
                                    ->label('Dosage'),
                                TextColumn::make('medicaments.duree')
                                    ->label('Durée'),
                            ])
                            ->relationship('ordonnances.medicaments'),
                    ]),
                // Autres onglets, si nécessaire
            ]),
                    Tabs\Tab::make('Explorations Fonctionnelles')
                        ->schema([
                            // Use a table or list to display explorations fonctionnelles
                        ]),
                    Tabs\Tab::make('Explorations Complémentaires')
                        ->schema([
                            // Use a table or list to display explorations complémentaires
                        ]),
        ];
    }
}
