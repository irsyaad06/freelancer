<?php

namespace Database\Seeders;

use App\Models\PackageService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    $this->call(CategorySeeder::class);
    $this->call(SubcategorySeeder::class);
    // $this->call(FreelancerSeeder::class);
    $this->call(WebSettingSeeder::class);
}

}
