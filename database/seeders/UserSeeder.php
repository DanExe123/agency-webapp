<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => bcrypt('password'), // 🔑
            ]
        );
        $admin->assignRole('Admin');

        // Company User
        $company = User::firstOrCreate(
            ['email' => 'company@example.com'],
            [
                'name'     => 'Company User',
                'password' => bcrypt('password'),
            ]
        );
        $company->assignRole('Company');

        // Agency User
        $agency = User::firstOrCreate(
            ['email' => 'agency@example.com'],
            [
                'name'     => 'Agency User',
                'password' => bcrypt('password'),
            ]
        );
        $agency->assignRole('Agency');
    }
}
