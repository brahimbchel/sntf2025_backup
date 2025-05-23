<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use App\Filament\Resources\EmployeResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateEmploye extends CreateRecord
{
    protected static string $resource = EmployeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Créer l'utilisateur
        $user = User::create([
            'email' => $data['user']['email'],
            'password' => Hash::make($data['user']['password']),
            'name' => $data['nom'] . ' ' . $data['prenom'],
            'role' => 'employe',
        ]);

        // Associer user_id à l'employé
        $data['user_id'] = $user->id;

        // $user->assignRole('employe');
        $user->role = 'employe';

        // Supprimer les champs inutiles
        unset($data['user']);

        return $data;
    }
    
}
