<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Desain & Kreatif']);
        Category::create(['name' => 'Pengembangan & IT']);
        Category::create(['name' => 'Penulisan & Penerjemahan']);
        Category::create(['name' => 'Pemasaran Digital']);
        Category::create(['name' => 'Video & Animasi']);
    }
}
