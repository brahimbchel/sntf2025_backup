<?php

namespace App\Filament\Resources\DossierMedicalResource\Pages;

use App\Filament\Resources\DossierMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;

class ViewDossierMedical extends ViewRecord
{
    protected static string $resource = DossierMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Identité')
                    ->columns(2)
                    ->icon('heroicon-m-identification')
                    ->iconColor('gray')
                    ->schema([
                        TextEntry::make('employe.nom')->label('Nom'),
                        TextEntry::make('employe.prenom')->label('Prénom'),
                        TextEntry::make('employe.matricule')->label('Matricule'),
                        TextEntry::make('employe.fonction')->label('Fonction'),
                        TextEntry::make('employe.departement.nom')->label('Nom du département'),
                    ])
                    ->collapsible(),

                Section::make('Coordonnées')
                    ->columns(2)
                    ->icon('heroicon-m-at-symbol')
                    ->iconColor('gray')
                    ->schema([
                        TextEntry::make('employe.adresse')->label('Adresse'),
                        TextEntry::make('employe.tel')->label('Téléphone'),
                        TextEntry::make('employe.email')->label('E-mail'),
                    ])
                    ->collapsible(),

                Section::make('Informations personnelles')
                ->icon('heroicon-m-information-circle')
                    ->columns(2)
                    ->iconColor('gray')
                    ->schema([
                        TextEntry::make('employe.datedenaissance')->label('Date de naissance'),
                        TextEntry::make('employe.gender')->label('Sex'),
                        TextEntry::make('employe.groupe_sanguin')->label('Groupe sanguin'),
                        TextEntry::make('employe.situation_familiale')->label('Situation familiale'),
                        TextEntry::make('employe.service_national')->label('Service national'),
                        TextEntry::make('employe.etat')->label('État'),
                    ])
                    ->collapsible(),

                Section::make('Activité Professionnelle Antérieure')
                ->icon('heroicon-m-briefcase')
                ->iconColor('gray')
                ->description('Les expériences professionnelles précédentes du patient.')
                ->aside()
                ->schema([
                    TextEntry::make('activite_professionnelles_anterieures')
                        ->label('Activités antérieures')
                        ->markdown(),
                ]),

                Section::make('Antécédents Familiaux')
                    ->icon('heroicon-m-user-group')
                    ->iconColor('gray')
                    ->description('Historique médical de la famille du patient \n
                     Recherche de diabète, tuberculose, alcoolisme, H.T.A, troubles psychiques, maladies héréditaires cause de décès..')
                    ->aside()
                    ->schema([
                        TextEntry::make('antecedents_familiaux')
                            ->label('Antécédents familiaux')
                            ->markdown(),
                    ]),

                Section::make('Antécédents Personnels')
                    ->icon('heroicon-m-clipboard-document-list')
                    ->iconColor('gray')
                    ->description("Regroupe les informations sur les affections congénitales, les maladies générales (chroniques ou non), les interventions chirurgicales subies, ainsi que les antécédents d’accidents ou d’intoxications (tabac, alcool, substances toxiques, etc.). ")
                    ->aside()
                    ->schema([
                        TextEntry::make('antecedents_personnels')
                            ->label('Antécédents personnels')
                            ->markdown(),
                    ]),

                Section::make('Maladies Professionnelles')
                    ->icon('heroicon-m-document-duplicate')
                    ->iconColor('gray')
                    ->description('les maladies à caractère professionnel diagnostiquées, les expositions prolongées à des risques professionnels (produits chimiques, bruit, stress, etc.), ainsi que les antécédents d’accidents de travail et leurs conséquences éventuelles.')
                    ->aside()
                    ->schema([
                        TextEntry::make('maladies_professionnelles')
                            ->label('Maladies professionnelles')
                            ->markdown(),
                    ]),

                Section::make('Observations')
                    ->icon('heroicon-m-pencil-square')
                    ->iconColor('gray')
                    ->description('Remarques ou observations générales.')
                    ->aside()
                    ->schema([
                        TextEntry::make('observations')
                            ->label('Observations')
                            ->markdown(),
                    ]),
            ]);
    }
}
