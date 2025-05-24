<?php

namespace App\Filament\Resources\OrdonnanceResource\Pages;

use App\Filament\Resources\OrdonnanceResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ViewOrdonnance extends ViewRecord
{
    protected static string $resource = OrdonnanceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informations d\'employé')
                    ->icon('heroicon-m-identification')
                    ->iconColor('gray')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('consultation.dossier_medical.employe.nom')->label('Nom'),
                        TextEntry::make('consultation.dossier_medical.employe.prenom')->label('Prénom'),
                        TextEntry::make('consultation.dossier_medical.employe.matricule')->label('Matricule'),
                        TextEntry::make('consultation.dossier_medical.employe.fonction')->label('Fonction'),
                        TextEntry::make('consultation.dossier_medical.employe.departement.nom')->label('Département'),
                    ])
                    ->collapsible(),

                Section::make('Ordonnance')
    ->icon('heroicon-m-clipboard-document-list')
    ->iconColor('gray')
    ->columns(1)
    ->schema([
        TextEntry::make('recommandations')
            ->label('Recommandations')
            ->markdown()
            ->default('Aucune recommandation'),

        RepeatableEntry::make('ordonnance_medicaments')
            ->label('Médicaments')
            ->schema([
                TextEntry::make('medicament.nom')->label('Nom du médicament'),
                TextEntry::make('dosage')->label('Dosage'),
                TextEntry::make('duree')->label('Durée'),
            ])
            ->columns(3),
    ])
    ->collapsible(),

            ]);
    }
}
