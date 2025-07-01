<?php

namespace Database\Factories;

use App\Models\SupplierType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'contact_person' => $this->faker->optional()->name(),
            'supplier_number' => 'L' . $this->faker->unique()->numerify('####'),
            'supplier_type_id' => SupplierType::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
