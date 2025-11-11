<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['superadmin', 'admin', 'usuario'] as $name) {
            Role::firstOrCreate(['name' => $name]);
        }
    }
}