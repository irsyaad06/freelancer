<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subcategory::create(['category_id' => 1, 'name' => 'Logo Design']);
        Subcategory::create(['category_id' => 1, 'name' => 'Web Design']);
        Subcategory::create(['category_id' => 2, 'name' => 'Web Development']);
        Subcategory::create(['category_id' => 2, 'name' => 'Mobile Development']);
        Subcategory::create(['category_id' => 3, 'name' => 'Content Writer']);
        Subcategory::create(['category_id' => 4, 'name' => 'Social Media Manager']);
        Subcategory::create(['category_id' => 5, 'name' => 'Video Editor']);
    }
}
