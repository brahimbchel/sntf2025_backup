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

         // Create user first
        $user = User::create([
            'email' => $data['user']['email'],
            'password' => Hash::make($data['user']['password']),
            'name' => $data['user']['name'] ?? "null",
        ]);

        // Assign 'medecin' role
        // $user->assignRole('medecin');
        $user->role = 'medecin';

         // Remove 'user' subarray from employe data
        unset($data['user']);

        // Link user to employe
        $data['user_id'] = $user->id;

        return $data;
    }  
}
