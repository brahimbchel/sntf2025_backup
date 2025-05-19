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
        if (!isset($data['user']['email'], $data['user']['password'])) {
            throw new \Exception("User email or password is missing.");
        }

         // Create user first
        $user = User::create([
            'email' => $data['user']['email'],
            'password' => Hash::make($data['user']['password']),
            'name' => $data['user']['name'] ?? "null",
        ]);

        $user->assignRole('employe');

         // Remove 'user' subarray from employe data
        unset($data['user']);

        // Link user to employe
        $data['user_id'] = $user->id;

        return $data;
    }  
}
