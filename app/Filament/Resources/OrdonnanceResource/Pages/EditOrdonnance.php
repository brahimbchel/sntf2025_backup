<?php

namespace App\Filament\Resources\OrdonnanceResource\Pages;

use App\Filament\Resources\OrdonnanceResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditOrdonnance extends EditRecord
{
    protected static string $resource = OrdonnanceResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        $user = Auth::user();

        // Vérifie que l'utilisateur est un médecin et que c'est lui le propriétaire de la consultation liée à l'ordonnance
        if (
            !$user->isMedecin() || // méthode personnalisée dans ton modèle User
            $this->record->consultation->medecin_id !== $user->medecin->id
        ) {
            abort(403); // Refus d'accès
        }
    }
}
