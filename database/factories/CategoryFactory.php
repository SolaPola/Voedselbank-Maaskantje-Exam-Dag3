<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Dairy', 'Meat', 'Vegetables', 'Fruits', 'Grains', 'Beverages', 'Snacks', 'Frozen']),
            'description' => $this->faker->sentence(),
        ];
    }
}
