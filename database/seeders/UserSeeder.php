<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure upload folders exist
        Storage::disk('public')->makeDirectory('uploads/logos');
        Storage::disk('public')->makeDirectory('uploads/bpls');
        Storage::disk('public')->makeDirectory('uploads/dtis');

        // Copy sample files from /database/seeders/sample to /storage/app/public/uploads
        $samples = [
            'logo_company.png' => 'uploads/logos/logo_company.png',
            'logo_agency.png'  => 'uploads/logos/logo_agency.png',
            'bpl.pdf'          => 'uploads/bpls/bpl.pdf',
            'dti.pdf'          => 'uploads/dtis/dti.pdf',
        ];

        foreach ($samples as $source => $destination) {
            $sourcePath = database_path("seeders/sample/{$source}");
            if (file_exists($sourcePath) && !Storage::disk('public')->exists($destination)) {
                Storage::disk('public')->put($destination, file_get_contents($sourcePath));
            }
        }

        // --- ADMIN USER ---
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'           => 'Admin User',
                'password'       => bcrypt('password'),
                'account_status' => 'pending',
            ]
        );
        $admin->assignRole('Admin');

        // --- COMPANY USER ---
        $company = User::firstOrCreate(
            ['email' => 'company@example.com'],
            [
                'name'           => 'Company User',
                'password'       => bcrypt('password'),
                'account_status' => 'pending',
            ]
        );
        $company->assignRole('Company');

        UserProfile::updateOrCreate(
            ['user_id' => $company->id],
            [
                'about_us'           => 'We are a leading security company providing professional guards.',
                'logo_path'          => 'uploads/logos/logo_company.png',
                'logo_original_name' => 'logo_company.png',
                'bpl_path'           => 'uploads/bpls/bpl.pdf',
                'bpl_original_name'  => 'bpl.pdf',
                'dti_path'           => 'uploads/dtis/dti.pdf',
                'dti_original_name'  => 'dti.pdf',
                'organization_type'  => 'Private',
                'industry_type'      => 'Security Services',
                'team_size'          => '50+',
                'year_established'   => '2015-06-15',
                'website'            => 'https://companysecurity.test',
                'vision'             => 'To be the most trusted security provider nationwide.',
                'address'            => 'Bacolod City',
                'phone'              => '09181234567',
            ]
        );

        // --- AGENCY USERS ---
        $agencies = [
            [
                'email' => 'agency1@example.com',
                'name'  => 'Agency One',
                'about' => 'We connect companies with skilled guards for deployment.',
                'website' => 'https://agencyone.test',
                'phone' => '09190000001',
                'vision' => 'To be the bridge between security professionals and businesses.',
            ],
            [
                'email' => 'agency2@example.com',
                'name'  => 'Agency Two',
                'about' => 'A trusted manpower agency for various security needs.',
                'website' => 'https://agencytwo.test',
                'phone' => '09190000002',
                'vision' => 'To redefine recruitment with integrity and excellence.',
            ],
            [
                'email' => 'agency3@example.com',
                'name'  => 'Agency Three',
                'about' => 'Providing reliable guards and workforce solutions nationwide.',
                'website' => 'https://agencythree.test',
                'phone' => '09190000003',
                'vision' => 'To provide quality staffing solutions with a human touch.',
            ],
        ];

        foreach ($agencies as $data) {
            $agency = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'           => $data['name'],
                    'password'       => bcrypt('password'),
                    'account_status' => 'pending',
                ]
            );
            $agency->assignRole('Agency');

            UserProfile::updateOrCreate(
                ['user_id' => $agency->id],
                [
                    'about_us'           => $data['about'],
                    'logo_path'          => 'uploads/logos/logo_agency.png',
                    'logo_original_name' => 'logo_agency.png',
                    'bpl_path'           => 'uploads/bpls/bpl.pdf',
                    'bpl_original_name'  => 'bpl.pdf',
                    'dti_path'           => 'uploads/dtis/dti.pdf',
                    'dti_original_name'  => 'dti.pdf',
                    'organization_type'  => 'Private',
                    'industry_type'      => 'Recruitment',
                    'team_size'          => '50+',
                    'year_established'   => '2018-04-10',
                    'website'            => $data['website'],
                    'vision'             => $data['vision'],
                    'address'            => 'Bacolod City',
                    'phone'              => $data['phone'],
                ]
            );
        }
    }
}
