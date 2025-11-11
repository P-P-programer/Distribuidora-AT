<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'felipemendoza3247@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $user->assignRole('superadmin');
    }
}