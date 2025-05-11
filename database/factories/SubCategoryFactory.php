<?php

namespace Database\Factories;

use App\Models\Categories; // Use plural model name
use Illuminate\Database\Eloquent\Factories\Factory;

class SubCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'category_id' => Categories::factory(), // Use Categories
        ];
    }
}
