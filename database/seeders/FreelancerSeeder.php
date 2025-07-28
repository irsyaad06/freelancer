<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Freelancer;
use App\Models\ServicePackage;
use App\Models\PackageService;

class FreelancerSeeder extends Seeder
{
    public function run(): void
    {
        // Freelancer 1 - John Smith
        $freelancer1 = Freelancer::create([
            'name' => 'John Smith',
            // Tambah kolom lain jika ada (misal email, bio, dll)
        ]);

        $basicLogo = $freelancer1->servicePackages()->create([
            'title' => 'Basic Logo',
            'description' => 'Simple logo design with 2 revisions',
            'price' => 100000,
            'delivery_time' => '2',
        ]);

        $premiumLogo = $freelancer1->servicePackages()->create([
            'title' => 'Premium Logo',
            'description' => 'Full logo package with source files',
            'price' => 300000,
            'delivery_time' => '5',
        ]);

        $basicLogo->services()->createMany([
            ['name' => '1x Revisi', 'is_included' => true],
            ['name' => 'File PNG', 'is_included' => true],
        ]);

        $premiumLogo->services()->createMany([
            ['name' => '5x Revisi', 'is_included' => true],
            ['name' => 'Source File (AI)', 'is_included' => true],
            ['name' => 'Mockup Presentasi', 'is_included' => true],
        ]);

        // Freelancer 2 - Alice Green
        $freelancer2 = Freelancer::create([
            'name' => 'Alice Green',
        ]);

        $webDev = $freelancer2->servicePackages()->create([
            'title' => 'Web Dev Package',
            'description' => 'Website development with backend and hosting',
            'price' => 1500000,
            'delivery_time' => '7',
        ]);

        $webDev->services()->createMany([
            ['name' => 'Frontend Development', 'is_included' => true],
            ['name' => 'Backend API (Laravel)', 'is_included' => true],
            ['name' => 'Hosting Setup', 'is_included' => false],
        ]);
    }
}
