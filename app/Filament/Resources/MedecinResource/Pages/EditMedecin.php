<?php

namespace App\Filament\Resources\MedecinResource\Pages;

use App\Filament\Resources\MedecinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditMedecin extends EditRecord
{
    protected static string $resource = MedecinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
{
    $medecin = $this->record;

    // Met à jour email si présent
    if (isset($data['user']['email'])) {
        $medecin->user->email = $data['user']['email'];
    }

    // Mot de passe si changé
    if (!empty($data['user']['password'])) {
        $medecin->user->password = Hash::make($data['user']['password']);
    }

    // Met à jour user.name avec nom + prenom du formulaire
    $medecin->user->name = trim(($data['nom'] ?? $medecin->nom) . ' ' . ($data['prenom'] ?? $medecin->prenom));

    $medecin->user->save();

    unset($data['user']); // éviter l'écrasement direct

    return $data;
}

}