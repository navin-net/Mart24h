<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    protected $model = \App\Models\Categories::class; // Use plural model name

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
