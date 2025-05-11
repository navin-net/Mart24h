<?php

namespace Database\Seeders;

use App\Models\Categories; // Use plural model name
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Categories::factory() // Use Categories
            ->count(5)
            ->has(SubCategory::factory()->count(3))
            ->create();

    }
}
