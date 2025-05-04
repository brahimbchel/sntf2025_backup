<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'medecin', 'employe', 'agent_de_saisie'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
        ])->assignRole('admin');

        User::firstOrCreate([
            'email' => 'medecin@example.com',
        ], [
            'name' => 'Medecin',
            'password' => bcrypt('password'),
        ])->assignRole('medecin');

        User::firstOrCreate([
            'email' => 'employe@example.com',
        ], [
            'name' => 'Employe',
            'password' => bcrypt('password'),
        ])->assignRole('employe');

        User::firstOrCreate([
            'email' => 'agent@example.com',
        ], [
            'name' => 'Agent de Saisie',
            'password' => bcrypt('password'),
        ])->assignRole('agent_de_saisie');
    }
}
