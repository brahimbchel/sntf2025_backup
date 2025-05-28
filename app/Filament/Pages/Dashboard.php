<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\ConsultationsStatistiques;
use App\Filament\Widgets\ConsultationChart;
use App\Filament\Widgets\MedecinsBySpecialiteChart;
use App\Filament\Widgets\TopMedecins;
use App\Filament\Widgets\AdminLatestConsultationsWidget;
use App\Filament\Widgets\NextConsultationCard;
use App\Filament\Widgets\MobileAppCard;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | string | array
    {
        return [
            'md' => 4,
            'xl' => 6, // Augmenter pour permettre plus de widgets par ligne sur des écrans larges
        ];
    }

    protected static ?int $sort = 2;

    public function getWidgets(): array
    {
        return [
            // Section 1 : Vue d'ensemble
            StatsOverview::class, // Vue d'ensemble des statistiques
            ConsultationsStatistiques::class, // Statistiques des consultations

            // Section 2 : Graphiques
            ConsultationChart::class, // Graphique des consultations par mois
            MedecinsBySpecialiteChart::class, // Graphique des médecins par spécialité

            // Section 3 : Tableaux
            TopMedecins::class, // Tableau des meilleurs médecins
            AdminLatestConsultationsWidget::class, // Dernières consultations administratives

            // Section 4 : Widgets spécifiques
            NextConsultationCard::class, // Widget pour la prochaine consultation
            MobileAppCard::class, // Widget pour promouvoir l'application mobile
        ];
    }
}