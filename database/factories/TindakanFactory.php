<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tindakan>
 */
class TindakanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Tindakan #' . $this->faker->numberBetween(1),
            'description' => $this->faker->boolean() ? $this->faker->realText() : null,
            'min_point' => $this->faker->numberBetween(5, 30),
            'max_point' => $this->faker->numberBetween(30, 60),
            'is_active' => $this->faker->boolean(80)
        ];
    }
}
