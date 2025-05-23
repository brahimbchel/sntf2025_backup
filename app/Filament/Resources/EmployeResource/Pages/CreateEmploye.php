<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use App\Filament\Resources\EmployeResource;
use App\Models\User;
use App\Notifications\SendLoginInfoNotification;
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

        $user->notify(new SendLoginInfoNotification(
                $user->email,
                $data['user']['password']
            ));

        // Associer user_id à l'employé
        $data['user_id'] = $user->id;

        // Supprimer les champs inutiles
        unset($data['user']);

        return $data;
    }

    // protected function afterCreate(): void
    // {
    //     // Get the associated user
    //     $user = $this->record->user;
        
    //     // Send notification if user exists
    //     if ($user && $user->email) {
    //         $user->notify(new SendLoginInfoNotification(
    //             $user->email,
    //             $user->password
    //         ));
    //     }
    // }
    
}
