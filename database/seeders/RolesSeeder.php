<?php
// database/seeders/RolesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'medecin']);
        Role::create(['name' => 'employe']);
        Role::create(['name' => 'agent_de_saisie']);
    }
}
