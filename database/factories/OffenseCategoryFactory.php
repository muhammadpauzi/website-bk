<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OffenseCategory>
 */
class OffenseCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Pelanggaran #' . $this->faker->numberBetween(1),
            'description' => $this->faker->boolean() ? $this->faker->realText() : null,
            'point' => $this->faker->numberBetween(5, 40),
            'is_active' => $this->faker->boolean(80)
        ];
    }
}
