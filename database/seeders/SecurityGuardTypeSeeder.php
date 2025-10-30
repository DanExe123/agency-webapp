<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SecurityGuardType; 

class SecurityGuardTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Unarmed Security Guard', 'description' => 'Handles patrols, access control, and surveillance without firearms.'],
            ['name' => 'Armed Security Guard', 'description' => 'Carries firearms, assigned to high-risk or valuable areas.'],
            ['name' => 'Mobile Patrol Guard', 'description' => 'Patrols multiple sites or large properties.'],
            ['name' => 'Event Security Guard', 'description' => 'Crowd control and access management during events.'],
            ['name' => 'Corporate Security Guard', 'description' => 'Protects office and corporate environments.'],
            ['name' => 'Industrial Security Guard', 'description' => 'Secures factories, construction sites, or warehouses.'],
            ['name' => 'Residential Security Guard', 'description' => 'Monitors gated communities and residential complexes.'],
            ['name' => 'CCTV / Monitoring Guard', 'description' => 'Specialized in remote video and alarm monitoring.'],
            ['name' => 'Bodyguard / VIP Protection', 'description' => 'Personal protection for individuals or executives.'],
        ];

        foreach ($types as $type) {
            SecurityGuardType::create($type);
        }
    }
}
