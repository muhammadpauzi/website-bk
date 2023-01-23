<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\_Parent>
 */
class _ParentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name,
            'alamat' => $this->faker->address,
            'phone' => '08' . $this->faker->numerify('##########'),
            'gender' => $this->faker->randomElement(['l', 'p'])
        ];
    }
}
