<?php

namespace App\Filament\Resources\OrdonnanceResource\Pages;

use App\Filament\Resources\OrdonnanceResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Actions\Action;
use Filament\Support\Facades\FilamentAsset;
use Filament\Notifications\Notification;

class ViewOrdonnance extends ViewRecord
{
    protected static string $resource = OrdonnanceResource::class;

    protected function getHeaderActions(): array
    {
    return [
            Action::make('imprimer')
                ->label('Imprimer')
                ->icon('heroicon-o-printer')
                ->color('info')
                ->action(function () {
                    // Redirection vers une route d’impression
                    return redirect()->route('ordonnances.print', ['record' => $this->record->id]);
                }),
        ];
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
                        TextEntry::make('consultation.dossier_medical.employe.datedenaissance')->label('Date de naissance')->date('d/m/Y'),
                        TextEntry::make('consultation.dossier_medical.employe.departement.nom')->label('Département'),
                        TextEntry::make('consultation.dossier_medical.employe.fonction')->label('Fonction'),
                    ])
                    ->collapsible(),

                Section::make('Ordonnance')
                ->icon('heroicon-m-clipboard-document-list')
                ->iconColor('gray')
                ->columns(1)
                ->schema([
                     TextEntry::make('recommandations')
                         ->size(TextEntry\TextEntrySize::Large)
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
