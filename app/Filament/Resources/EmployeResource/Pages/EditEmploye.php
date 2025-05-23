<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use App\Filament\Resources\EmployeResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Actions;

class EditEmploye extends EditRecord
{
    protected static string $resource = EmployeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $employe = $this->record;

        // Mise à jour de l'email si modifié
        if (isset($data['user']['email'])) {
            $employe->user->email = $data['user']['email'];
        }

        // Mise à jour du mot de passe si renseigné
        if (!empty($data['user']['password'])) {
            $employe->user->password = Hash::make($data['user']['password']);
        }

        // Mise à jour automatique du nom complet dans user.name
        $employe->user->name = trim(($data['nom'] ?? $employe->nom) . ' ' . ($data['prenom'] ?? $employe->prenom));

        $employe->user->save();

        unset($data['user']); // On retire 'user' du tableau pour éviter des conflits

        return $data;
    }
}
