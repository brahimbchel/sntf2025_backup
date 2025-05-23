<?php

namespace App\Filament\Resources\MedecinResource\Pages;

use App\Filament\Resources\MedecinResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateMedecin extends CreateRecord
{
    protected static string $resource = MedecinResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['user']['email'], $data['user']['password'])) {
            throw new \Exception("User email or password is missing.");
        }

        // Création du compte utilisateur
        $user = User::create([
            'email' => $data['user']['email'],
            'password' => Hash::make($data['user']['password']),
            'name' => $data['medecin']['nom'] . ' ' . $data['medecin']['prenom'],
            'role' => 'medecin',
        ]);

        unset($data['user']);

        // Liaison avec le médecin
        $data['user_id'] = $user->id;

        return $data;
    }
}
